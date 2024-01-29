<div class="row">
    <ul class="nav nav-tabs nav-primary" role="tablist">
        @foreach($tabs as $key => $tab)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $key == $activeTab ? 'active' : '' }}" href="#primaryhome" role="tab" wire:click="changeTab('{{ $key }}')">
                <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class='bx bxs-home font-18 me-1'></i>
                    </div>
                    <div class="tab-title">{{ $tab }}</div>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    <div class="tab-content py-3">
        @foreach($tabs as $key => $tab)
        <div class="tab-pane {{ $key == $activeTab ? 'active' : '' }}" id="primaryhome" role="tabpanel">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            @livewire($tab)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
