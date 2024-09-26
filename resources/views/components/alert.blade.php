    <!-- Blade template using merge of attributes -->
<div {{ $attributes
        ->class(['alert', 'alert-'.$type])
        ->merge(['type' => 'alert']) 
    }} 
    role="alert" > 
    <!-- Blade template using attributes of component -->

    {{$message}}

</div>