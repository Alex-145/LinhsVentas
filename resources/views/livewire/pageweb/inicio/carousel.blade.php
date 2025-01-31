<div x-data="carousel()"
     x-init="startAutoPlay"
     @keydown.right="next"
     @keydown.left="prev"
     class="relative w-full max-w-4xl mx-auto">
    <!-- Carousel Wrapper -->
    <div class="relative overflow-hidden rounded-lg shadow-lg aspect-w-16 aspect-h-9">
        <div x-ref="carousel" class="flex transition-transform duration-500 ease-in-out">
            @foreach ($images as $index => $image)
                <!-- Use x-show to display only the current image -->
                <div :class="{'opacity-0': currentIndex !== {{ $index }}}"
                     x-transition:enter="transition-opacity duration-300"
                     x-transition:leave="transition-opacity duration-300"
                     class="w-full h-full flex-shrink-0">
                    <img src="{{ asset('storage/' . $image) }}" alt="carousel image" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Previous and Next Buttons -->
    <button @click="prev" @keydown.enter="prev"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 opacity-75 hover:opacity-100 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <button @click="next" @keydown.enter="next"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 opacity-75 hover:opacity-100 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @foreach ($images as $index => $image)
            <button @click="currentIndex = {{ $index }}" @keydown.enter="currentIndex = {{ $index }}"
                    class="w-3 h-3 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                    :class="currentIndex === {{ $index }} ? 'bg-white' : 'bg-gray-600 hover:bg-gray-400'">
            </button>
        @endforeach
    </div>
</div>

<script>
function carousel() {
    return {
        currentIndex: @entangle('currentIndex'),
        total: {{ count($images) }},
        startAutoPlay() {
            setInterval(() => {
                this.next();
            }, 5000); // Change slide every 5 seconds
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.total;
            this.updateTransform();
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.total) % this.total;
            this.updateTransform();
        },
        updateTransform() {
            const offset = -this.currentIndex * 100;
            this.$refs.carousel.style.transform = `translateX(${offset}%)`;
        }
    }
}
</script>
