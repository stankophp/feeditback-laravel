<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse($movies as $movie)
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                <h4 class="flex">
                                    {{ $movie->title }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="body">
                            {{ $movie->description }}
                        </div>
                    </div>
                </div>
            @empty
                <p>No movies here yet</p>
            @endforelse
            {{ $movies->links() }}
        </div>
    </div>
</div>
