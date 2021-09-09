<div class="m-6 p-6">
    <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th scope="col">제목</th>
            <th scope="col">작성자</th>
            <th scope="col">작성일</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
          <tr>
            <th scope="row">{{ $post->title }}</th>
            <td>{{ $post->writer->name }}</td>
            <td>{{ $post->created_at->diffForHumans() }}</td>            
          </tr>
          @endforeach
        </tbody>
      </table>
</div>