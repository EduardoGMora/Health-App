<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use App\Models\Exercise;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        
        // 1. Estado de ánimo actual
        $currentMood = DiaryEntry::where('user_id', $user->id)
                        ->whereDate('created_at', $today)
                        ->latest()
                        ->first();
        
        // 2. Estadísticas de ejercicios (últimos 7 días)
        $exerciseStats = $this->getExerciseStats($user);
        
        // 3. Recursos vistos recientemente
        $recentResources = Resource::whereIn('id', function($query) use ($user) {
                            $query->select('resource_id')
                                  ->from('resource_views')
                                  ->where('user_id', $user->id);
                        })
                        ->orderByDesc('created_at')
                        ->limit(3)
                        ->get();
        
        // 4. Progreso semanal (estado de ánimo)
        $moodTrend = $this->getMoodTrend($user);
        
        // 5. Sugerencias personalizadas
        $suggestions = $this->generateSuggestions($currentMood, $exerciseStats);
        
        return view('dashboard', compact(
            'currentMood',
            'exerciseStats',
            'recentResources',
            'moodTrend',
            'suggestions'
        ));
    }
    
    protected function getExerciseStats($user)
    {
        return [
            'today' => Exercise::where('user_id', $user->id)
                        ->whereDate('created_at', today())
                        ->count(),
            'week' => Exercise::where('user_id', $user->id)
                        ->whereBetween('created_at', [now()->subDays(7), today()])
                        ->count(),
            'favorite' => Exercise::where('user_id', $user->id)
                            ->select('type')
                            ->groupBy('type')
                            ->orderByRaw('COUNT(*) DESC')
                            ->first()
                            ->type ?? 'Ninguno'
        ];
    }
    
    protected function getMoodTrend($user)
    {
        $moods = DiaryEntry::where('user_id', $user->id)
                    ->whereBetween('created_at', [now()->subDays(6), now()])
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->created_at)->format('D'); // Día de la semana
                    });
        
        return $moods->map(function($dayEntries) {
            return round($dayEntries->avg(function($entry) {
                // Convertir emoji a valor numérico para el gráfico
                return $this->moodToNumber($entry->mood);
            }), 2);
        });
    }
    
    protected function moodToNumber($mood)
    {
        $moodScale = [
            '😢' => 1,
            '😞' => 2,
            '😐' => 3,
            '🙂' => 4,
            '😊' => 5
        ];
        
        return $moodScale[$mood] ?? 3;
    }
    
    protected function generateSuggestions($currentMood, $exerciseStats)
    {
        $suggestions = [];
        
        if (!$currentMood) {
            $suggestions[] = [
                'type' => 'warning',
                'message' => 'No has registrado tu estado de ánimo hoy',
                'action' => route('diary.create')
            ];
        } elseif ($this->moodToNumber($currentMood->mood) < 3) {
            $suggestions[] = [
                'type' => 'alert',
                'message' => 'Tu estado de ánimo parece bajo, ¿quieres probar un ejercicio de relajación?',
                'action' => route('exercises.index', ['type' => 'meditation'])
            ];
        }
        
        if ($exerciseStats['today'] == 0) {
            $suggestions[] = [
                'type' => 'info',
                'message' => 'No has completado ejercicios hoy',
                'action' => route('exercises.index')
            ];
        }
        
        if (empty($suggestions)) {
            $suggestions[] = [
                'type' => 'success',
                'message' => '¡Buen trabajo! Sigue así',
                'action' => null
            ];
        }
        
        return $suggestions;
    }
}