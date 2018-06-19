<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('posts')->truncate();
        DB::table('roles')->truncate();
        DB::table('categories')->truncate();
        DB::table('photos')->truncate();
        DB::table('comments')->truncate();
        DB::table('comment_replies')->truncate();

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'is_active' => 1,
            'password' => bcrypt(123456),
        ]);

        DB::table('roles')->insert([
            'name' => 'administrator',
        ]);
        DB::table('roles')->insert([
            'name' => 'author',
        ]);
        DB::table('roles')->insert([
            'name' => 'subscriber',
        ]);

        DB::table('categories')->insert([
            'name' => 'General',
        ]);
        DB::table('categories')->insert([
            'name' => 'Programming',
        ]);
        DB::table('categories')->insert([
            'name' => 'Tech',
        ]);
        DB::table('categories')->insert([
            'name' => 'Science',
        ]);
        DB::table('categories')->insert([
            'name' => 'Music',
        ]);

        factory(App\User::class,10)->create()->each(function($user){
            $user->posts()->save(factory(App\Post::class)->make());
        });

        factory(App\Photo::class,1)->create();

        factory(App\Comment::class,10)->create()->each(function($c){
            $c->replies()->save(factory(App\CommentReply::class)->make());
        });

    }
}
