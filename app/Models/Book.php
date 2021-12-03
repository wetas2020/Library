<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function path() {
        return '/books/' .$this->id;
    }

    public function setAuthorIdAttribute($author) {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author,
        ]))->id;
    }

    public function checkout(User $user) {

        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }


    public function checkin(User $user) {
        $reservation =  $this->reservations()->where('user_id', $user->id)->whereNotNull('checked_out_at')->whereNull('checked_in_at')->first();

        if (is_null($reservation)) {
            throw new \Exception();
        }
        $reservation->update([
            'checked_in_at' => now(),
        ]);
    }

}
