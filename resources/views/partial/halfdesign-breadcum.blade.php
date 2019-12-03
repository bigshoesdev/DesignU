<div class="breadcum">
    <div class="container">
        <div class="pull-right">
            @if($product)
            @switch($product->register_step)
            @case(1)
            <a href="{{route('halfdesign.setinfo', ['id' => $product->id])}}">
                <i class="livicon icon3" data-name="info" data-size="22" data-loop="true" data-c="#525234"
                   data-hc="#525234"></i>
                <span class="breadcum-page-title">Information</span>
            </a>
            @break
            @case(2)
            <a href="{{route('halfdesign.setinfo', ['id' => $product->id])}}">
                <i class="livicon icon3" data-name="info" data-size="22" data-loop="true" data-c="#525234"
                   data-hc="#525234"></i>
                <span class="breadcum-page-title">Information</span>
            </a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{{route('halfdesign.setauto', ['id' => $product->id])}}">
                <i class="livicon icon3" data-name="unlink" data-size="22" data-loop="true" data-c="#525234"
                   data-hc="#525234"></i>
                <span class="breadcum-page-title">Automation</span>
            </a>
            @break
            @case(3)
            <a href="{{route('halfdesign.setinfo', ['id' => $product->id])}}">
                <i class="livicon icon3" data-name="info" data-size="22" data-loop="true" data-c="#525234"
                   data-hc="#525234"></i>
                <span class="breadcum-page-title">Information</span>
            </a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{{route('halfdesign.setauto', ['id' => $product->id])}}">
                <i class="livicon icon3" data-name="unlink" data-size="22" data-loop="true" data-c="#525234"
                   data-hc="#525234"></i>
                <span class="breadcum-page-title">Automation</span>
            </a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{{route('halfdesign.setprint', ['id' => $product->id])}}">
                <i class="livicon icon3" data-name="printer" data-size="22" data-loop="true"
                   data-c="#525234"
                   data-hc="#525234"></i>
                <span class="breadcum-page-title">Printing</span>
            </a>
            @break
            @endswitch
            @endif
        </div>
    </div>
</div>
