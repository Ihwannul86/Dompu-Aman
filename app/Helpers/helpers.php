<?php

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd F Y')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime($datetime, $format = 'd F Y H:i')
    {
        return \Carbon\Carbon::parse($datetime)->format($format);
    }
}

if (!function_exists('time_ago')) {
    function time_ago($datetime)
    {
        return \Carbon\Carbon::parse($datetime)->diffForHumans();
    }
}

if (!function_exists('status_badge')) {
    function status_badge($status)
    {
        $badges = [
            'pending' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
            'reviewing' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Reviewing</span>',
            'investigating' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Investigating</span>',
            'resolved' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Resolved</span>',
            'rejected' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>',
            'closed' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Closed</span>',
            'draft' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>',
            'published' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Published</span>',
            'archived' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Archived</span>',
            'active' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>',
            'locked' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Locked</span>',
            'hidden' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Hidden</span>',
            'inactive' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Inactive</span>',
            'banned' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Banned</span>',
        ];

        return $badges[$status] ?? '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . ucfirst($status) . '</span>';
    }
}

if (!function_exists('priority_badge')) {
    function priority_badge($priority)
    {
        $badges = [
            'low' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Low</span>',
            'medium' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Medium</span>',
            'high' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">High</span>',
            'urgent' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>',
        ];

        return $badges[$priority] ?? '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . ucfirst($priority) . '</span>';
    }
}

if (!function_exists('truncate_text')) {
    function truncate_text($text, $length = 100)
    {
        return \Illuminate\Support\Str::limit(strip_tags($text), $length);
    }
}

if (!function_exists('get_avatar')) {
    function get_avatar($user, $size = 40)
    {
        if ($user && $user->avatar) {
            return asset('storage/' . $user->avatar);
        }

        $name = $user ? urlencode($user->name) : 'User';
        return "https://ui-avatars.com/api/?name={$name}&size={$size}&background=667eea&color=fff";
    }
}

if (!function_exists('active_menu')) {
    function active_menu($route, $class = 'active')
    {
        return request()->routeIs($route) ? $class : '';
    }
}
