<template>
    <main class="flex justify-center items-center bg-pink-950 w-full">
        <div class="w-5/6 h-5/6 bg-stone-50 flex justify-stretch content-stretch gap-24 rounded-lg shadow-2xl">
            <router-view class="flex basis-1 grow text-left pl-32"></router-view>
            <div class="basis-1 grow flex flex-col justify-center items-center pr-32">
                <img src="/vault.svg" alt="A drawing of a man putting some money into a vault"/>
            </div>
        </div>
    </main>
</template>

<script>

</script>

<style scoped>

</style>
