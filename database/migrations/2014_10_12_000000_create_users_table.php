<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status')->default(-1);
            $table->boolean('paid')->default(0);
            $table->integer('expiry')->default(0);
            $table->integer('popularity')->default(0);
            $table->string('address',1000)->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('contactemail')->nullable();
            $table->string('website')->nullable();
            $table->string('description',5000)->nullable();
            $table->integer('category_id');
            $table->integer('city_id');
            $table->rememberToken();
            $table->timestamps();
        });

        $user=new User();
        $user->username='Admin';
        $user->password=bcrypt('123456789');
        $user->email='admin@gmail.com';
        $user->status=1;
        $user->paid=1;
        $user->popularity=-1;
        $user->category_id=1;
        $user->city_id=1;
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
