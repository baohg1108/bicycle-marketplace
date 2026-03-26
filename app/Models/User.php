<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    use HasFactory;

    
   protected $fillable = [
    "full_name",
    "phone",
    "email",
    "password",
    "avatar_url", 
    "role",
    "status",
    "email_verified_at",
    "phone_verified_at",
    "last_login_at",
   ];

   protected $hidden = [
    "password",
   ];

   protected $casts = [
    "email_verified_at" => "datetime",
    "phone_verified_at" => "datetime",
    "last_login_at" => "datetime",
   ];

   // relationships
   // 1:1 - user_profiles
   public function profile() {
    return $this->hasOne(UserProfile::class);
   }

   public function inspectorProfile(){
    return $this->hasOne(InspectorProfile::class, 'user_id');
    }       

   // 1-n - user_addresses
   public function addresses() {
    return $this->hasMany(UserAddress::class);
   }

   // 1-n - listings (seller)
   public function listings() {
    return $this->hasMany(Listing::class);
   }

   // 1-n - orders (buyer)
   public function orders() {
    return $this->hasMany(Order::class, 'buyer_id');
   }

    // 1-n: orders (seller)
    public function soldOrders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    // 1-n: messages send
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // wishlist - table pivot
    public function wishlists()
{
    return $this->belongsToMany(Listing::class, 'wishlists')
        ->withTimestamps();
}

    // saved searches
    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    // conversations buyer
    public function buyerConversations()
    {
        return $this->hasMany(Conversation::class, 'buyer_id');
    }

    // conversations seller
    public function sellerConversations()
    {
        return $this->hasMany(Conversation::class, 'seller_id');
    }
}
