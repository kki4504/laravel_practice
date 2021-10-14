{{-- :posts="$post" View/Component로 가서 생성자가 받음 --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Post') }}
            </h2>
            <button onclick=location.href="{{ route('posts.show', ['post'=>$post->id]) }}" 
                    type="button" 
                    class="btn btn-info hover:bg-blue-700 font-bold text-white"
                    >
                    상세보기
            </button>
        </div>
    </x-slot>
    <div class="m-6 p-6">
        {{-- file보내는 form에서 method="post enctype="multipart" --}}
        <form class="row g-3" 
              action="{{ route('posts.update', ['post' => $post->id]) }}"
              name="editForm"
              id="editForm"
              method="post"
              enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="col-12 m-2">
                <label for="title" class="form-label">제목</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $post->title }}"/>
                @error('title')
                    <div class="text-red-800">
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="col-12 m-2">
                <label for="content" class="form-label">글 내용</label>
                <textarea 
                    class="form-control" 
                    name="content" 
                    id="content" 
                    cols="30" rows="10" 
                    >{{ $post->content }}</textarea>
                @error('content')
                    <div class="text-red-800">
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="col-12 m-2">
                @if ($post->image)
                    <div class="flex item-center">
                        <img class="w-20 h-20 rounded-full mb-4" src="{{ '/storage/images/'.$post->image }}" class="card-img-top" alt="my post image">
                
                        <button onclick="return deleteImage({{ $post->id }})" class="btn btn-danger h-10 mt-3 ml-3">이미지 삭제</button>
                    </div>
                @else
                    <span>첨부 이미지 없음</span>
                @endif
                <label for="image" class="form-label">첨부 이미지</label>
                <input type="file" name="image" class="form-control" id="image">
            </div>
            <div class="col-12 m-2">
              <button type="submit" class="btn btn-primary">글수정</button>
            </div>
        </form>
        <script>
            deleteImage = (id) => {
                editForm = document.getElementById('editForm');
                // editForm.delete('_method');
                editForm._method.value = 'delete';
                editForm.action = '/posts/images/'+id;
                editForm.submit();
                return ture;
                // alert('hi~');
            }
        </script>
    </div>
</x-app-layout>
