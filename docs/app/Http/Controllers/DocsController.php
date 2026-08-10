<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function show($module = 'introduction', $page = 'index')
    {
        $viewPath = "docs.pages.{$module}.{$page}";

        if (!view()->exists($viewPath)) {
            abort(404);
        }

        $sidebar = $this->getSidebarItems();

        return view('docs.show', [
            'viewPath' => $viewPath,
            'sidebar' => $sidebar,
            'currentModule' => $module,
            'currentPage' => $page,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        if (!$query) return response()->json(['results' => []]);

        $results = [];
        $modules = $this->getSidebarItems();

        foreach ($modules as $module) {
            $viewPath = "docs.pages.{$module['slug']}.index";
            
            if (view()->exists($viewPath)) {
                $html = view($viewPath)->render();
                $text = strip_tags($html);
                
                if (stripos($text, $query) !== false) {
                    // Extract a small excerpt
                    $pos = stripos($text, $query);
                    $start = max(0, $pos - 50);
                    $excerpt = substr($text, $start, 150) . '...';
                    
                    $results[] = [
                        'title' => $module['label'],
                        'module' => $module['label'],
                        'url' => "/docs/{$module['slug']}",
                        'excerpt' => $excerpt
                    ];
                }
            }
        }

        return response()->json(['results' => $results]);
    }

    private function getSidebarItems()
    {
        return [
            ['label' => 'Introduction', 'slug' => 'introduction', 'icon' => 'home'],
            ['label' => 'Users', 'slug' => 'users', 'icon' => 'users'],
            ['label' => 'Roles', 'slug' => 'roles', 'icon' => 'shield'],
            ['label' => 'Besdex', 'slug' => 'besdex', 'icon' => 'database'],
            ['label' => 'Attendance Records', 'slug' => 'attendance-records', 'icon' => 'calendar-check'],
            ['label' => 'My Leads', 'slug' => 'my-leads', 'icon' => 'user-plus'],
            ['label' => 'Proposal', 'slug' => 'proposal', 'icon' => 'file-text'],
            ['label' => 'My Attendance', 'slug' => 'my-attendance', 'icon' => 'clock'],
            ['label' => 'Salary', 'slug' => 'salary', 'icon' => 'credit-card'],
            ['label' => 'To-Do', 'slug' => 'todo', 'icon' => 'check-square'],
            ['label' => 'Task', 'slug' => 'task', 'icon' => 'clipboard'],
            ['label' => 'Calendar', 'slug' => 'calendar', 'icon' => 'calendar'],
            ['label' => 'Links and Remarks', 'slug' => 'links-remarks', 'icon' => 'link'],
            ['label' => 'Interaction', 'slug' => 'interaction', 'icon' => 'message-square'],
            ['label' => 'Invoice', 'slug' => 'invoice', 'icon' => 'receipt'],
            ['label' => 'Leave Record', 'slug' => 'leave-record', 'icon' => 'file-minus'],
            ['label' => 'Leave Apply', 'slug' => 'leave-apply', 'icon' => 'file-plus'],
            ['label' => 'Contact', 'slug' => 'contact', 'icon' => 'phone'],
            ['label' => 'Project Management', 'slug' => 'project-management', 'icon' => 'layers'],
            ['label' => 'Report', 'slug' => 'report', 'icon' => 'bar-chart-2'],
            ['label' => 'Notepad', 'slug' => 'notepad', 'icon' => 'edit-3'],
            ['label' => 'My Tickets', 'slug' => 'my-tickets', 'icon' => 'headphones'],
            ['label' => 'Upgrade Plan', 'slug' => 'upgrade-plan', 'icon' => 'star'],
        ];
    }
}
