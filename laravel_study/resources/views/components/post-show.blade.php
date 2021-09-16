<div class="container">
    <div class="card" style="width: 100%;">
        @if ($post->image)
            <img src="{{ '/storage/images/'.$post->image }}" class="card-img-top" alt="my post image">
        @else
            <span>첨부 이미지 없음</span>
        @endif
        <div class="card-body">
          <h5 class="card-title">{{ $post->title }}</h5>
          <p class="card-text">{{ $post->content }}</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">등록일: {{ $post->created_at->diffForHumans() }}</li>
          <li class="list-group-item">수정일: {{ $post->updated_at->diffForHumans() }}</li>
          <li class="list-group-item">작성자: {{ $post->writer->name }}</li>
        </ul>
        <div class="card-body">
          <a href="#" class="card-link">수정하기</a>
          <a href="#" class="card-link">삭제하기</a>
        </div>
      </div>
</div>