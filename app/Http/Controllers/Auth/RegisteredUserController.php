<?php

namespace App\Http\Controllers\Auth;

use App\Functions\UsefulFunctions;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\InecLga;
use App\Models\InecState;
use App\Models\InecWard;
use App\Models\State;
use App\Models\User;
use App\Rules\LgaVerificationRule;
use App\Rules\StateVerificationRule;
use App\Rules\WardVerificationRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{

    public $functions;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }
    /**
     * Display the registration view.
     */
    public function create()
    {
        $props['year'] = date('Y');
        $states = InecState::where('id', '!=', '0')->orderBy("name", "ASC");
        $props['props_states'] = $states->get();
        $state = $states->first();
        $props['state'] = $state->id;

        $lgas = InecLga::where('inec_state_id', $state->id)->orderBy("name", "ASC");
        $props['props_lgas'] = $lgas->get();
        $lga = $lgas->first();
        $props['lga'] = $lga->id;

        $wards = InecWard::where('inec_state_id', $state->id)->where('inec_lga_id', $lga->id)->orderBy("name", "ASC");
        $props['props_wards'] = $wards->get();
        $ward = $wards->first();
        $props['ward'] = $ward->id;

        // return $props;

        return Inertia::render('Auth/NewRegister', $props);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|alpha_dash|max:35|unique:'.User::class,
            'email' => 'required|string|lowercase|email|max:50|unique:'.User::class,
            'state' => ['required', 'integer', new StateVerificationRule],
            'lga' => ['required', 'integer', new LgaVerificationRule($request->state)],
            'ward' => ['required', 'integer', new WardVerificationRule($request->state, $request->lga)],
            'phone' => 'required|max:16',

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);




        $user = User::create([


            'sponsor_user_id' => User::inRandomOrder()->first()->id,
            'name' => $request->name,
            'user_name' => strtolower($request->user_name),
            'slug' => $this->functions->generateUniqueSlugForUser($request->user_name),
            'email' => $request->email,
            'country_id' => 151,
            'state_id' => $request->state,
            'lga_id' =>  $request->lga,
            'ward_id' =>  $request->ward,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home_page', absolute: false));
    }
}
