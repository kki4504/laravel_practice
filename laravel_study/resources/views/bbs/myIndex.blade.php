{{-- :posts="$post" View/Component로 가서 생성자가 받음 --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Posts') }}
            </h2>
            <button 
                onclick=location.href="{{ route('posts.create') }}" 
                type="button" 
                class="btn btn-info hover:bg-blue-700 font-bold text-white"
                >
                    글쓰기
            </button>
        </div>
    </x-slot>
    <x-posts-list :posts="$posts" />
</x-app-layout>
