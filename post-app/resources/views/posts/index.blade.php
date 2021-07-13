<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('목록리스트') }}
        </h2>
    </x-slot>
    <div class="container mt-5">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark mb-3">Dashboard</a>
        <h1>게시글 리스트</h1>
        @auth 
            <a href="/posts/create" class="btn btn-outline-dark">게시글 작성</a>
        @endauth
        <ul class="list-group">
            @foreach($posts as $post)
            <li class="list-group-item">
                <div>
                    <span>
                        <a href="{{ route('posts.show', ['id'=>$post->id, 'page'=>$posts->currentPage()]) }}">Title : {{ $post->title }}</a>
                    </span>
                    <span style="float: right">written on {{ $post->created_at->diffForHumans() }}</span>
                </div>

                {{-- 컨텐츠 표시 --}}
                {{-- <div>

                    content : {{ $post->content }}
                </div> --}}
                <div class="mb-2">
                    <span style="float: right">
                        {{ $post -> viewers -> count() }} 
                        {{ $post -> viewers -> count() > 0 ? Str::plural('view', $post -> viewers -> count()) : 'view' }}  <!-- view 복수로 표시하는 방법 -->
                    </span>
                </div>
                
            </li>
            @endforeach
        </ul>
        <div class="mt-5">
            {{-- 자동 링크생성 --}}
            {{ $posts -> links() }}
        </div>
    </div>
</x-app-layout>