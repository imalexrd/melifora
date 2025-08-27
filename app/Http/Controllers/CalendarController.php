<?php

namespace App\Http\Controllers;

use App\Models\ApiaryNote;
use App\Models\HiveNote;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $apiaryTasks = ApiaryNote::where('type', 'task')
            ->whereNotNull('due_date')
            ->with('apiary')
            ->get();

        $hiveTasks = HiveNote::where('type', 'task')
            ->whereNotNull('due_date')
            ->with('hive.apiary')
            ->get();

        $events = [];

        foreach ($apiaryTasks as $task) {
            $events[] = [
                'title' => $task->content,
                'start' => $task->due_date->format('Y-m-d H:i:s'),
                'url' => route('apiaries.show', $task->apiary_id),
                'color' => $this->getTaskColor($task),
                'description' => 'Tarea en apiario: ' . $task->apiary->name,
            ];
        }

        foreach ($hiveTasks as $task) {
            $events[] = [
                'title' => $task->content,
                'start' => $task->due_date->format('Y-m-d H:i:s'),
                'url' => route('hives.show', $task->hive_id),
                'color' => $this->getTaskColor($task),
                'description' => 'Tarea en colmena: ' . $task->hive->name . ' (Apiario: ' . $task->hive->apiary->name . ')',
            ];
        }

        return view('calendar.index', compact('events'));
    }

    private function getTaskColor($task)
    {
        if ($task->completed_at) {
            return '#28a745'; // Green for completed
        }

        if ($task->due_date->isPast()) {
            return '#dc3545'; // Red for overdue
        }

        return '#007bff'; // Blue for upcoming
    }
}
