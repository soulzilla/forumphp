<?php

namespace App\Orchid\Layouts;

use App\Models\Theme;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ThemeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'themes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('user_id', __('User'))
                ->render(function (Theme $theme) {
                    return Link::make($theme->user->name)
                        ->route('platform.systems.users.edit', $theme->user);
                }),
            TD::make('title', __('Title'))
                ->render(function (Theme $theme) {
                    return Link::make($theme->title)
                        ->route('platform.theme.edit', $theme);
                }),
            TD::make('description', __('description'))
                ->render(function (Theme $theme) {
                    $description = substr($theme->description, 0, 50) . '...';

                    return Link::make($description)
                        ->route('platform.theme.edit', $theme);
                }),
            TD::make('created_at', __('Created')),
            TD::make('updated_at', __('Last edit')),
        ];
    }
}
