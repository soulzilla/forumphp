<?php

namespace App\Orchid\Screens\Theme;

use App\Models\Theme;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class ThemeEditScreen extends Screen
{
    /**
     * @var Theme
     */
    public $theme;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Theme $theme): iterable
    {
        return [
            'theme' => $theme
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Theme moderation');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('icon-check')
                ->method('save')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [];
    }

    public function save(Theme $theme, Request $request)
    {
        $theme->is_blocked = $request->get('is_blocked', false);
        $theme->blocked_reason = $request->get('blocked_reason', '');

        $theme->save();

        Alert::info(__('Theme has been moderated'));

        return redirect()->route('platform.theme.list');
    }
}
