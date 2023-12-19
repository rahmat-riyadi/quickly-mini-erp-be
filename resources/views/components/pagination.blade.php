@if ($paginator->hasPages())
<div class="d-flex flex-wrap py-2 mr-3">
    @if ($paginator->onFirstPage())
    <a class="disabled btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-double-arrow-back icon-xs"></i></a>
    <a class="disabled btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-arrow-back icon-xs"></i></a>
    @else
    <a wire:click="gotoPage(1, '{{ $paginator->getPageName() }}')" class="btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-double-arrow-back icon-xs"></i></a>
    <a wire:click="previousPage('{{ $paginator->getPageName() }}')" class="btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-arrow-back icon-xs"></i></a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
        <a class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">{{ $element }}</a>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <a class="btn btn-icon btn-sm border-0 btn-light btn-hover-primary active mr-2 my-1">{{ $page }}</a>
                @else
                <a href="javascript:;" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">{{ $page }}</a>
                @endif
            @endforeach
        @endif

    @endforeach


    @if ($paginator->hasMorePages())
    <a wire:click="nextPage('{{ $paginator->getPageName() }}')" class="btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-arrow-next icon-xs"></i></a>
    <a wire:click="gotoPage({{ $paginator->lastPage() }}, '{{ $paginator->getPageName() }}')" class="btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-double-arrow-next icon-xs"></i></a>
    @else
    <a class="disabled btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-arrow-next icon-xs"></i></a>
    <a class="disabled btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-double-arrow-next icon-xs"></i></a>
    @endif
    

</div>
@endif