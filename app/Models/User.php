<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Functions\UsefulFunctions;
use App\Notifications\FollowUserNotification;
use App\Notifications\UnFollowUserNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'community_leader_pending',
        'sponsor_user_id',
        'name',
        'user_name',
        'slug',
        'email',
        'country_id',
        'region_id',
        'is_admin',
        'phone',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    protected $appends = ['followers_num', 'following_num', 'following_status', 'following_loading', 'about_user_loading', 'country_details', 'total_posts_num', 'state_details', 'lga_details'];

    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }

    public function totalPostsNum(): Attribute {
        return Attribute::make(
            get: fn() => $this->posts()->count()
        );
    }

    public function countryDetails(): Attribute {
        return Attribute::make(
            get: fn() => $this->country()->first()
        );
    }

    public function stateDetails(): Attribute {
        return Attribute::make(
            get: fn() => $this->state()->first()
        );
    }

    public function lgaDetails(): Attribute {
        return Attribute::make(
            get: fn() => $this->lga()->first()
        );
    }

    public function wardDetails(): Attribute {
        return Attribute::make(
            get: fn() => $this->ward()->first()
        );
    }

    public function state() {
        return $this->belongsTo(InecState::class, 'state_id');
    }

    public function lga() {
        return $this->belongsTo(InecLga::class, 'lga_id');
    }

    public function ward() {
        return $this->belongsTo(InecWard::class, 'ward_id');
    }

    public function aboutUserLoading(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => false
        );
    }

    public function favoritePosts($all = false, $last_id = 0): HasMany
    {

        // return $all ? $this->hasMany(PostLike::class) : $this->hasMany(PostLike::class)->orderBy('id', 'DESC')->limit(10);

        if($all){
            return  $this->hasMany(PostFavorite::class);
        }else if(!$all && $last_id == 0){
            return $this->hasMany(PostFavorite::class)->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(PostFavorite::class)->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }

    public function followingLoading(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => false
        );
    }

    public function follow($user) {
        $this->following()->create(['followed' => $user->id]);
        $user->notify(new FollowUserNotification($this, $user));
    }

    public function unfollow($user) {
        $this->following()->where('followed', $user->id)->delete();
        $user->notify(new UnFollowUserNotification($this, $user));
    }

    public function profilePicture(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => is_null($value) ? '/default/avatar.jpg' : $value
        );
    }

    public function followingStatus(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->followers()->where('follower', auth()->id())->exists()
        );
    }

    public function followersNum(): Attribute {

        return Attribute::make(
            get: fn ($value, $attributes) => $this->followers(true)->count(),
        );
    }

    public function followingNum(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->following()->count(),
        );
    }


    public function followers($all = false, $last_id = 0): HasMany
    {

        // return $all ? $this->hasMany(PostLike::class) : $this->hasMany(PostLike::class)->orderBy('id', 'DESC')->limit(10);

        if($all){
            return  $this->hasMany(FollowDetail::class, 'followed');
        }else if(!$all && $last_id == 0){
            return $this->hasMany(FollowDetail::class, 'followed')->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(FollowDetail::class, 'followed')->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }

    public function following($all = false, $last_id = 0): HasMany
    {

        // return $all ? $this->hasMany(PostLike::class) : $this->hasMany(PostLike::class)->orderBy('id', 'DESC')->limit(10);

        if($all){
            return  $this->hasMany(FollowDetail::class, 'follower');
        }else if(!$all && $last_id == 0){
            return $this->hasMany(FollowDetail::class, 'follower')->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(FollowDetail::class, 'follower')->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }



    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }

    public function earningsHistory(){
        return $this->hasMany(EarningHistory::class);
    }

    public function savingsAutoWithdrawalHistory(){
        return $this->hasMany(SavingAutoWithdrawalHistory::class);
    }

    public function savings(){
        return $this->hasMany(EasySavings::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    protected function phoneCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value,$attributes) => Country::find($attributes['country_id'])->phone_code,
        );
    }

    public function adminDebitHistory()
    {
        return $this->hasMany(AdminDebitUsersHistory::class);
    }

    public function monnifyDetails(){
        return $this->hasMany(UserMonnifyDetail::class);
    }

    public function adminCreditHistory()
    {
        return $this->hasMany(AdminFundUsersHistory::class);
    }

    public function accountStatement() {
        return $this->hasMany(AccountStatement::class);
    }

    public function earningToWalletHist(){
        return $this->hasMany(EarningToWalletHistory::class);
    }

    public function accountCreditHistory()
    {
        return $this->hasMany(AccountCreditHistory::class);
    }

    public function withdrawalHistory()
    {
        return $this->hasMany(WithdrawalHistory::class);
    }
}
