
<div class="d-flex justify-content-center mt-4">
    <nav>
        <ul class="pagination">
            @if ($productos->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Anterior</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $productos->previousPageUrl() }}" class="page-link btn-ajax">Anterior</a>
                </li>
            @endif

            @for ($i = 1; $i <= $productos->lastPage(); $i++)
                <li class="page-item {{ $i == $productos->currentPage() ? 'active pastel-page' : '' }}">
                    <a href="{{ $productos->url($i) }}" class="page-link btn-ajax">{{ $i }}</a>
                </li>
            @endfor

            @if ($productos->hasMorePages())
                <li class="page-item">
                    <a href="{{ $productos->nextPageUrl() }}" class="page-link btn-ajax">Siguiente</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Siguiente</span>
                </li>
            @endif
        </ul>
    </nav>
</div>