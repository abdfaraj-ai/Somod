<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\SOSReport;
use App\Models\MarketUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'new_users_today' => User::whereDate('created_at', Carbon::today())->count(),
            'admins_count' => User::where('role', 'admin')->count(),
            'total_services' => Service::count(),
            'active_services' => Service::where('status', 'active')->count(),
        ];

        $userRegistrations = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $recentUsers = User::latest()->take(10)->get();

        $usersByArea = User::select('area', DB::raw('COUNT(*) as count'))
            ->groupBy('area')
            ->get();

        $recentServices = Service::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'userRegistrations', 
            'recentUsers', 
            'usersByArea',
            'recentServices'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        
        try {
            $user->load(['sosReports', 'marketUpdates']);
        } catch (\Exception $e) {
        }
        
        return view('admin.users.show', compact('user'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'area' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'area' => $request->area,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'area' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'area' => $request->area,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if (auth()->id() == $id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'مفعل' : 'معطل';
        return back()->with('success', "تم {$status} الحساب بنجاح");
    }

    public function systemStats()
    {
        $dailyStats = [
            'logins_today' => User::whereDate('last_login_at', Carbon::today())->count(),
            'registrations_today' => User::whereDate('created_at', Carbon::today())->count(),
        ];

        $roleStats = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role');

        $areaStats = User::select('area', DB::raw('COUNT(*) as count'))
            ->groupBy('area')
            ->orderByDesc('count')
            ->get();

        return view('admin.stats', compact('dailyStats', 'roleStats', 'areaStats'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'items_per_page' => 'required|integer|min:5|max:100',
        ]);

        return back()->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    public function services()
    {
        $services = Service::latest()->paginate(20);
        return view('admin.services.index', compact('services'));
    }

    public function showService($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show', compact('service'));
    }
}