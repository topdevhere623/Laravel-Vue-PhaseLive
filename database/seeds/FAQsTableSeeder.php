<?php

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('faqs')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 1,
                'question' => 'What is Phase?',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.

                                Maecenas quis massa id lacus mattis efficitur. Maecenas a suscipit metus, in auctor tortor. Phasellus cursus tellus ligula, ac laoreet massa pulvinar ac. Proin mi augue, ullamcorper sit amet justo et, feugiat sollicitudin magna. Aliquam suscipit orci nibh, eu fringilla libero lobortis in. Curabitur ultricies rutrum nulla, a hendrerit ligula mattis vitae. Sed maximus eleifend mi quis dapibus. Quisque dictum efficitur tortor ut vestibulum. Vestibulum consectetur ut dui eget interdum. Fusce vitae nisi ac velit vehicula pharetra. In laoreet pharetra ex, vitae pharetra nulla pellentesque ac. Sed sapien magna, ullamcorper at purus eget, suscipit accumsan ligula.',
                'sort_id' => 0,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 1,
                'question' => 'What is Thunderbolt?',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.',
                'sort_id' => 10,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 1,
                'question' => 'This site is really cool?',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis tincidunt lorem et dictum. In hac habitasse platea dictumst. Etiam ut varius ante. Suspendisse scelerisque volutpat neque, quis dignissim nibh sagittis ut. Praesent lacinia risus leo, pulvinar pulvinar magna iaculis sit amet. Integer quis luctus eros. Aenean quis eros blandit, maximus mauris vitae, dignissim nisi. Maecenas rutrum varius felis, ut imperdiet urna semper vel. Duis id molestie metus, in malesuada velit. Sed dignissim eros sodales laoreet consequat. Proin gravida augue at ex ultricies rhoncus. Curabitur tempor turpis at sodales laoreet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;

                                Aenean aliquet dolor vel pharetra accumsan. Maecenas id mi id nunc rutrum laoreet ut non risus. In vulputate turpis euismod, fringilla velit vitae, laoreet erat. Mauris molestie lacinia mauris, eget tristique nibh lobortis quis. Proin dictum finibus velit ac blandit. Cras in augue volutpat, facilisis orci id, tempor tortor. Pellentesque arcu augue, interdum vitae diam sed, sodales blandit augue. Sed vel tempus nunc, vel placerat ante. Integer nibh mauris, vehicula in consequat vel, egestas eu ipsum. Integer id vulputate diam, sed maximus neque. Cras quis nunc vitae elit tempus tincidunt sed non justo.
                                
                                Duis at quam non mi bibendum cursus a quis nibh. Donec ultrices molestie nisl, ac consequat magna convallis nec. In at interdum nunc. Sed ut mollis quam. Nunc aliquet, metus eget semper placerat, erat nunc gravida sem, eu iaculis neque metus in metus. Quisque imperdiet vulputate tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis dapibus lorem vitae dui molestie, in accumsan sem maximus. Phasellus accumsan tellus ante, ac sagittis mi faucibus sed. Praesent sit amet ante at justo dapibus convallis. Suspendisse lorem massa, aliquam ac lacus et, luctus accumsan ligula. Phasellus eu tristique ante.',
                'sort_id' => 20,
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 2,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.

                                Maecenas quis massa id lacus mattis efficitur. Maecenas a suscipit metus, in auctor tortor. Phasellus cursus tellus ligula, ac laoreet massa pulvinar ac. Proin mi augue, ullamcorper sit amet justo et, feugiat sollicitudin magna. Aliquam suscipit orci nibh, eu fringilla libero lobortis in. Curabitur ultricies rutrum nulla, a hendrerit ligula mattis vitae. Sed maximus eleifend mi quis dapibus. Quisque dictum efficitur tortor ut vestibulum. Vestibulum consectetur ut dui eget interdum. Fusce vitae nisi ac velit vehicula pharetra. In laoreet pharetra ex, vitae pharetra nulla pellentesque ac. Sed sapien magna, ullamcorper at purus eget, suscipit accumsan ligula.',
                'sort_id' => 0,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 2,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.',
                'sort_id' => 10,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 2,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis tincidunt lorem et dictum. In hac habitasse platea dictumst. Etiam ut varius ante. Suspendisse scelerisque volutpat neque, quis dignissim nibh sagittis ut. Praesent lacinia risus leo, pulvinar pulvinar magna iaculis sit amet. Integer quis luctus eros. Aenean quis eros blandit, maximus mauris vitae, dignissim nisi. Maecenas rutrum varius felis, ut imperdiet urna semper vel. Duis id molestie metus, in malesuada velit. Sed dignissim eros sodales laoreet consequat. Proin gravida augue at ex ultricies rhoncus. Curabitur tempor turpis at sodales laoreet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;

                                Aenean aliquet dolor vel pharetra accumsan. Maecenas id mi id nunc rutrum laoreet ut non risus. In vulputate turpis euismod, fringilla velit vitae, laoreet erat. Mauris molestie lacinia mauris, eget tristique nibh lobortis quis. Proin dictum finibus velit ac blandit. Cras in augue volutpat, facilisis orci id, tempor tortor. Pellentesque arcu augue, interdum vitae diam sed, sodales blandit augue. Sed vel tempus nunc, vel placerat ante. Integer nibh mauris, vehicula in consequat vel, egestas eu ipsum. Integer id vulputate diam, sed maximus neque. Cras quis nunc vitae elit tempus tincidunt sed non justo.
                                
                                Duis at quam non mi bibendum cursus a quis nibh. Donec ultrices molestie nisl, ac consequat magna convallis nec. In at interdum nunc. Sed ut mollis quam. Nunc aliquet, metus eget semper placerat, erat nunc gravida sem, eu iaculis neque metus in metus. Quisque imperdiet vulputate tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis dapibus lorem vitae dui molestie, in accumsan sem maximus. Phasellus accumsan tellus ante, ac sagittis mi faucibus sed. Praesent sit amet ante at justo dapibus convallis. Suspendisse lorem massa, aliquam ac lacus et, luctus accumsan ligula. Phasellus eu tristique ante.',
                'sort_id' => 20,
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 3,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.

                                Maecenas quis massa id lacus mattis efficitur. Maecenas a suscipit metus, in auctor tortor. Phasellus cursus tellus ligula, ac laoreet massa pulvinar ac. Proin mi augue, ullamcorper sit amet justo et, feugiat sollicitudin magna. Aliquam suscipit orci nibh, eu fringilla libero lobortis in. Curabitur ultricies rutrum nulla, a hendrerit ligula mattis vitae. Sed maximus eleifend mi quis dapibus. Quisque dictum efficitur tortor ut vestibulum. Vestibulum consectetur ut dui eget interdum. Fusce vitae nisi ac velit vehicula pharetra. In laoreet pharetra ex, vitae pharetra nulla pellentesque ac. Sed sapien magna, ullamcorper at purus eget, suscipit accumsan ligula.',
                'sort_id' => 0,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 3,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.',
                'sort_id' => 10,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 3,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis tincidunt lorem et dictum. In hac habitasse platea dictumst. Etiam ut varius ante. Suspendisse scelerisque volutpat neque, quis dignissim nibh sagittis ut. Praesent lacinia risus leo, pulvinar pulvinar magna iaculis sit amet. Integer quis luctus eros. Aenean quis eros blandit, maximus mauris vitae, dignissim nisi. Maecenas rutrum varius felis, ut imperdiet urna semper vel. Duis id molestie metus, in malesuada velit. Sed dignissim eros sodales laoreet consequat. Proin gravida augue at ex ultricies rhoncus. Curabitur tempor turpis at sodales laoreet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;

                                Aenean aliquet dolor vel pharetra accumsan. Maecenas id mi id nunc rutrum laoreet ut non risus. In vulputate turpis euismod, fringilla velit vitae, laoreet erat. Mauris molestie lacinia mauris, eget tristique nibh lobortis quis. Proin dictum finibus velit ac blandit. Cras in augue volutpat, facilisis orci id, tempor tortor. Pellentesque arcu augue, interdum vitae diam sed, sodales blandit augue. Sed vel tempus nunc, vel placerat ante. Integer nibh mauris, vehicula in consequat vel, egestas eu ipsum. Integer id vulputate diam, sed maximus neque. Cras quis nunc vitae elit tempus tincidunt sed non justo.
                                
                                Duis at quam non mi bibendum cursus a quis nibh. Donec ultrices molestie nisl, ac consequat magna convallis nec. In at interdum nunc. Sed ut mollis quam. Nunc aliquet, metus eget semper placerat, erat nunc gravida sem, eu iaculis neque metus in metus. Quisque imperdiet vulputate tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis dapibus lorem vitae dui molestie, in accumsan sem maximus. Phasellus accumsan tellus ante, ac sagittis mi faucibus sed. Praesent sit amet ante at justo dapibus convallis. Suspendisse lorem massa, aliquam ac lacus et, luctus accumsan ligula. Phasellus eu tristique ante.',
                'sort_id' => 20,
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 4,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.

                                Maecenas quis massa id lacus mattis efficitur. Maecenas a suscipit metus, in auctor tortor. Phasellus cursus tellus ligula, ac laoreet massa pulvinar ac. Proin mi augue, ullamcorper sit amet justo et, feugiat sollicitudin magna. Aliquam suscipit orci nibh, eu fringilla libero lobortis in. Curabitur ultricies rutrum nulla, a hendrerit ligula mattis vitae. Sed maximus eleifend mi quis dapibus. Quisque dictum efficitur tortor ut vestibulum. Vestibulum consectetur ut dui eget interdum. Fusce vitae nisi ac velit vehicula pharetra. In laoreet pharetra ex, vitae pharetra nulla pellentesque ac. Sed sapien magna, ullamcorper at purus eget, suscipit accumsan ligula.',
                'sort_id' => 0,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 4,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mattis gravida facilisis. Proin ultricies risus eget leo iaculis, non dapibus sapien ornare. Maecenas non venenatis sapien. Donec vulputate sagittis est, eu lacinia dolor. Nam maximus ligula felis. Aliquam in nulla massa. Vivamus augue nisi, blandit non iaculis at, vestibulum sit amet ex.',
                'sort_id' => 10,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'category_id' => 4,
                'question' => 'Lorem ipsum dolor sit amet',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis tincidunt lorem et dictum. In hac habitasse platea dictumst. Etiam ut varius ante. Suspendisse scelerisque volutpat neque, quis dignissim nibh sagittis ut. Praesent lacinia risus leo, pulvinar pulvinar magna iaculis sit amet. Integer quis luctus eros. Aenean quis eros blandit, maximus mauris vitae, dignissim nisi. Maecenas rutrum varius felis, ut imperdiet urna semper vel. Duis id molestie metus, in malesuada velit. Sed dignissim eros sodales laoreet consequat. Proin gravida augue at ex ultricies rhoncus. Curabitur tempor turpis at sodales laoreet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;

                                Aenean aliquet dolor vel pharetra accumsan. Maecenas id mi id nunc rutrum laoreet ut non risus. In vulputate turpis euismod, fringilla velit vitae, laoreet erat. Mauris molestie lacinia mauris, eget tristique nibh lobortis quis. Proin dictum finibus velit ac blandit. Cras in augue volutpat, facilisis orci id, tempor tortor. Pellentesque arcu augue, interdum vitae diam sed, sodales blandit augue. Sed vel tempus nunc, vel placerat ante. Integer nibh mauris, vehicula in consequat vel, egestas eu ipsum. Integer id vulputate diam, sed maximus neque. Cras quis nunc vitae elit tempus tincidunt sed non justo.
                                
                                Duis at quam non mi bibendum cursus a quis nibh. Donec ultrices molestie nisl, ac consequat magna convallis nec. In at interdum nunc. Sed ut mollis quam. Nunc aliquet, metus eget semper placerat, erat nunc gravida sem, eu iaculis neque metus in metus. Quisque imperdiet vulputate tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis dapibus lorem vitae dui molestie, in accumsan sem maximus. Phasellus accumsan tellus ante, ac sagittis mi faucibus sed. Praesent sit amet ante at justo dapibus convallis. Suspendisse lorem massa, aliquam ac lacus et, luctus accumsan ligula. Phasellus eu tristique ante.',
                'sort_id' => 20,
            ],
        ]);
    }
}
