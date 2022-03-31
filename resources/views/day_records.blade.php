<x-app-layout>
    @php
        renderTitle(
            "Registrar Ponto",
            "Mantenhao seu ponto consistente!",
            "fa-check"
        );
    @endphp
    <div class="card">
        <div class="card-header">
            <h3>{{ $today }}</h3>
            <p>os batimentos efetuados hoje</p>
        </div>
        <div class="card-body">
            <div class="flex m-5 justify-content-around">
                <span class="record">Entrada 1: ---</span>
                <span class="record">Saída 1: ---</span>
            </div>
            <div class="flex m-5 justify-content-around">
                <span class="record">Entrada 2: ---</span>
                <span class="record">Saída 2: ---</span>
            </div>
        </div>
        <div class="card-footer flex justify-center">
            <a href="???" class="btn btn-success btn-lg">
                <i class="fa-regular fa-circle-check"></i>
                Bater o Ponto
            </a>
        </div>
    </div>
</x-app-layout>
