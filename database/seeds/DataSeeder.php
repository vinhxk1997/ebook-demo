<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\Models\User::all();
        $metas = App\Models\Meta::all();
        $stories = App\Models\Story::all();
        $chapters = App\Models\Chapter::all();
        $save_lists = App\Models\SaveList::all();
        // metas
        $meta_data = [];
        foreach ($stories as $story) {
            $story_metas = $metas->random(5);
            foreach ($story_metas as $meta) {
                $meta_data[] = [
                    'meta_id' => $meta->id,
                    'story_id' => $story->id,
                ];
            }
        }
        DB::table('meta_story')->insert($meta_data);
        // archives
        $archive_data = [];
        foreach ($users as $user) {
            $archive_stories = $stories->random(5);
            foreach ($archive_stories as $story) {
                $archive_data[] = [
                    'user_id' => $user->id,
                    'story_id' => $story->id,
                    'is_archive' => rand(0, 1),
                ];
            }
        }
        DB::table('archives')->insert($archive_data);
        // save_lists
        $save_data = [];
        foreach ($save_lists as $list) {
            $save_stories = $stories->random(5);
            foreach ($save_stories as $story) {
                $save_data[] = [
                    'list_id' => $list->id,
                    'story_id' => $story->id,
                ];
            }
        }
        DB::table('list_story')->insert($save_data);
        // follows
        $follow_data = [];
        foreach ($users as $user) {
            $followings = $users->random(5);
            foreach ($followings as $following) {
                $follow_data[] = [
                    'followed_user_id' => $user->id,
                    'following_user_id' => $following->id,
                ];
            }
        }
        DB::table('follows')->insert($follow_data);
        // comment
        $comment_data = [];
        foreach ($chapters as $chapter) {
            if (rand(0, 1)) {
                $comment_data = array_merge($comment_data, factory(App\Models\Comment::class, rand(4, 9))->make([
                    'user_id' => $users->random(1)->first()->id,
                    'commentable_type' => App\Models\Chapter::class,
                    'commentable_id' => $chapter->id,
                    'created_at' => now()->subDays(4),
                    'updated_at' => now()
                ])->toArray());
            }
        }
        DB::table('comments')->insert($comment_data);
    }
}
