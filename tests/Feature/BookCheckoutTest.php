<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCheckoutTest extends TestCase
{
    use refreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out_by_a_signed_in_user() {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $this->actingAs($user = User::factory()->create())->post('/checkout/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_out_at);

    }

    /** @test */
    public function only_signed_in_users_can_checkout_a_book() {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $this->post('/checkout/' . $book->id)->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
        // $this->assertEquals($user->id, Reservation::first()->user_id);
        // $this->assertEquals($book->id, Reservation::first()->book_id);
        // $this->assertEquals(now(),Reservation::first()->checked_out_at);

    }

    /** @test*/
    public function only_real_books_can_be_checked_out() {
        // $book = Book::factory()->create();
        $this->actingAs($user = User::factory()->create())->post('/checkout/123')->assertStatus(404);

        $this->assertCount(0, Reservation::all());
        // $this->assertEquals($user->id, Reservation::first()->user_id);
        // $this->assertEquals($book->id, Reservation::first()->book_id);
        // $this->assertEquals(now(),Reservation::first()->checked_out_at);

    }

    /** @test */
    public function a_book_can_be_checked_in_by_a_signed_in_user() {
        $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user)->post('/checkout/' . $book->id);
        $this->actingAs($user)->post('/checkin/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_in_at);
        $this->assertEquals(now(),Reservation::first()->checked_out_at);

    }



      /** @test */
      public function only_signed_in_users_can_checkin_a_book() {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $this->actingAs(User::factory()->create())->post('/checkout/' . $book->id);

        Auth::logout();
        $this->post('/checkin/' . $book->id)->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());
        // $this->assertEquals($user->id, Reservation::first()->user_id);
        // $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNull(Reservation::first()->checked_in_at);

    }

    /** @test*/
    public function a_404_is_thrown_if_a_book_is_not_checked_out_first() {

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/checkin/' . $book->id)->assertStatus(404);

        $this->assertCount(0, Reservation::all());

    }

}
