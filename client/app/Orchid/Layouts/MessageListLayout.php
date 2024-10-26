<?php

namespace App\Orchid\Layouts;

use App\Models\Message;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MessageListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'messages';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('theme_id', 'Theme')
                ->render(function (Message $model) {
                    return Link::make($model->theme->title)
                        ->route('platform.theme.edit', $model->theme);
                }),
            TD::make('user_id', 'User')
                ->render(function (Message $model) {
                    return Link::make($model->user->name)
                        ->route('platform.systems.users.edit', $model->user);
                }),
            TD::make('content', 'Content')
                ->render(function (Message $model) {
                    $content = substr($model->content, 0, 50) . '...';

                    return Link::make($content)
                        ->route('platform.message.edit', $model);
                }),
            TD::make('is_blocked', 'Blocked')
                ->render(function (Message $model) {
                    return $model->is_blocked ? __('Yes') : __('No');
                }),
            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
        ];
    }
}
