<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div>
            <a href="{{ route('posts.index', ['page'=>$page]) }}">목록보기</a>
        </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" readonly name="title" class="form-control" id="title" value="{{ $post -> title }}">

            </div>
            <div class="form-group">
                <label for="content">Content</label></label>
                <div readonly name="content" id="content">{!! $post -> content !!}</div>
            </div>
            {{-- src 짧게 쓰는 방법 --}}
            <div class="form-group">
                <label for="imageFile">Post Image</label></label>
                <div>
                                                                        {{-- imagePath() ->  post.php 파일에 만들어줌 --}}
                    <img class="img-thumbnail" width="20%" src="{{ $post->imagePath() }}"/>
                </div>
            </div>
            {{-- <div class="form-group">
                <label for="imageFile">Post Image</label></label>
                <div>
                    <img class="img-thumbnail" width="20%" src="/storage/images/{{ $post->image ?? 'no_image_available.png'}}"/>
                </div>
            </div> --}}
            <div class="form-group">
                <label>등록일</label>
                <textarea type="text" readonly class="form-control">{{ $post -> created_at -> diffForHumans() }}</textarea>
            </div>
            <div class="form-group">
                <label>수정일</label>
                <textarea type="text" readonly class="form-control">{{ $post -> updated_at }}</textarea>
            </div>
            <div class="form-group">
                <label>작성자</label>
                <input type="text" readonly class="form-control" value="{{ $post -> user -> name }}">
            </div>

            {{-- authentication --}}
            @auth
                {{-- authorization --}}
                {{-- @if (auth() -> user() -> id == $post -> user_id) --}}
                @can('update', $post)
                    <div class="flex">
                        <a class="btn btn-warning" href = "{{ route('posts.edit' , ['post'=> $post -> id, 'page' => $page]) }}">수정</a>

                        {{-- delete form --}}
                        <form action = "{{ route('posts.delete', ['id' => $post -> id, 'page' => $page]) }}" method="post">
                            @csrf
                            @method("delete")
                            <button type = "submit" class = "btn btn-danger">삭제</button>
                        </form>
                    </div>
                @endcan
                {{-- @endif --}}
            @endauth
            {{-- <button class="btn btn-primary" onclick = "location.href = {{ route('posts.index', [ 'page' => 1])  }}">목록보기</button> --}}
    </div>
</body>
</html>