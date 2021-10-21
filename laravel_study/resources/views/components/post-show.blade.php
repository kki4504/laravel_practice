<div class="container">
  <div class="mx-14">
    <div class="card mt-4 mx-5">
        @if ($post->image)
          <div class="justify-items-center">
            <img src="{{ '/storage/images/'.$post->image }}" class="card-img-top w-2/4 h-3/4" alt="my post image">
          </div>
        @else
            <span class="m-3">첨부 이미지 없음</span>
        @endif
        <div class="card-body">
          <h5 class="card-title">{{ $post->title }}</h5>
          <p class="card-text">{{ $post->content }}</p>
        </div>
        <div>
          <hr />
          <like-button :post="{{ $post }}" :loginuser="{{ auth()->user()->id }}" />
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">등록일: {{ $post->created_at->diffForHumans() }}</li>
          <li class="list-group-item">수정일: {{ $post->updated_at->diffForHumans() }}</li>
          <li class="list-group-item">작성자: {{ $post->writer->name }}</li>
        </ul>
        <div class="card-body flex">
          <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="card-link">수정하기</a>
          <form id="form" class="ml-4" name="" method="post" 
            onsubmit="event.preventDefault(); confirmDelete(event)"
            action="{{ route('posts.destroy', ['post' => $post->id]) }}">
            @csrf
            @method('delete')
            {{-- <input type="hidden" name="_method" value="delete"> --}}
            <button>삭제하기</button>
          </form>
        </div>
      </div>
      <div class="card mt-2 mb-5 mx-5">
        <comment-list :post="{{ $post }}" :loginuser="{{ auth()->user()->id }}"/>
      </div>
  </div>
</div>