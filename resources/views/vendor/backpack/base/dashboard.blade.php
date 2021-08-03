@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
    $widgets['before_content'][] = [
        'type'    => 'div',
        'class'   => 'row',
        'content' => [ // widgets 
            [ 'type' => 'card', 'content' => ['body' => 'One'] ],
            [ 'type' => 'card', 'content' => ['body' => 'Two'] ],
            [ 'type' => 'card', 'content' => ['body' => 'Three'] ],
        ]
    ];
    $userCount = App\Models\User::count();
    debugbar()->info($userCount);
    Widget::add()->to('before_content')->type('div')->class('row')->content([
        Widget::make()
			->type('progress_white')
			->class('card border-0 text-dark bg-light')
			->progressClass('progress-bar')
			->value($userCount)
			->description('Registered users.')
			->progress(100*(int)$userCount/1000)
			->hint(1000-$userCount.' more until next milestone.'),
    ]);
    
@endphp

@section('content')
    
@endsection