<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Message;

use App\Models\Message;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MessageEditScreen extends Screen
{
    /**
     * @var Message
     */
    public $message;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Message $message): iterable
    {
        return [
            'message' => $message,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Message moderation';
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
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('message.user_id')
                    ->readonly()
                    ->title('User')
                    ->help('User who sent the message')
                    ->value($this->message->user->name),

                Input::make('message.theme_id')
                    ->readonly()
                    ->title('Theme')
                    ->help('Theme to which the message belongs')
                    ->value($this->message->theme->title),

                Quill::make('message.content')
                    ->title('Message')
                    ->readonly()
                    ->help('Message content'),

                CheckBox::make('message.is_blocked')
                    ->title('Block message')
                    ->help('Block message from being displayed')
                    ->sendTrueOrFalse(),

                Quill::make('message.block_reason')
                    ->title('Block reason')
                    ->help('Reason for blocking the message')
                    ->placeholder('Enter the reason for blocking the message')
                    ->onlyIf('message.is_blocked', true)
            ])
        ];
    }

    public function save(Message $message, Request $request)
    {
        $message->is_blocked = $request->get('message.is_blocked', false);
        $message->blocked_reason = $request->get('message.block_reason', '');

        $message->save();

        Alert::info(__('Message was successfully moderated.'));

        return redirect()->route('platform.message.list');
    }
}
