<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
	first_page_url: String,
	from: Number,
	last_page: Number,
	last_page_url: String,
	links: Array,
	next_page_url: String,
	prev_page_url: String,
	to: Number,
	total: Number,
});
</script>

<template>
	<!-- This example requires Tailwind CSS v2.0+ -->
	<div
		class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
	>
		<!-- <div class="flex flex-1 justify-between sm:hidden">
			<Link
				:href="prev_page_url"
				class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
				>Previous
			</Link>
			<Link
				:href="next_page_url"
				class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
				>Next
			</Link>
		</div> -->
		<div
			class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
		>
			<div>
				<p class="text-sm text-gray-700">
					Showing
					<span class="font-medium">{{ from ?? 0 }}</span>
					to
					<span class="font-medium">{{ to ?? 0 }}</span>
					of
					<span class="font-medium">{{ total }}</span>
					results
				</p>
			</div>
			<div>
				<nav
					class="isolate inline-flex -space-x-px rounded-md shadow-sm"
					aria-label="Pagination"
				>
					<Component
						:is="link.url ? Link : 'span'"
						v-for="link in links"
						:key="link.label"
						:href="link.url"
						v-html="link.label"
						class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium hover:bg-gray-50 focus:z-20"
						:class="{
							'text-gray-500': !link.url,
							'z-10 bg-indigo-50 border-indigo-500 text-indigo-600 font-bold':
								link.active,
						}"
					/>
				</nav>
			</div>
		</div>
	</div>
</template>
