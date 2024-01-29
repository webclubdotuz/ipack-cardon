<ul class="nav nav-tabs nav-primary" role="tablist">
    @foreach($links as $link)
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bx bxs-home font-18 me-1'></i>
                </div>
                <div class="tab-title">Home</div>
            </div>
        </a>
    </li>
    @endforeach
</ul>
<div class="tab-content py-3">
    @foreach($tabs as $tab)
    <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">

    </div>
    @endforeach
</div>
