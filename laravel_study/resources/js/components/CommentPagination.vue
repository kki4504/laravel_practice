<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap mb-1">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class="px-4 py-3 mb-1 mr-1 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <div v-else :key="key" @click="pageClicked(link.url)" 
        class="px-4 py-3 mb-1 bg-white-100 font-bold mr-1 text-sm leading-4 border rounded hover:bg-blue-400 focus:border-indigo-500 focus:text-indigo-500" 
        :class="{ 'bg-blue-300': link.active }" 
        :href="link.url" 
        v-html="link.label" />
      </template>
      
    </div>
  </div>
</template>

<script>
export default {
  props: {
    links: Array
  },
  methods: {
    pageClicked(url){
      this.$emit('pageClicked', url);
    }
  }
}
</script>