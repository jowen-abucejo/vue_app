<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";
import { Inertia } from "@inertiajs/inertia";

let props = defineProps({
	employees: Object,
	filters: Object,
});

const formatDate = (string_date) => {
	return string_date.substring(0, 10);
};

const deleteEmployee = (id) => {
	let c = confirm("Are you sure to delete this employee Record");
	if (c) {
		Inertia.delete(`employees/${id}`);
	}
};

let search = ref(props.filters.search);

watch(search, (value) => {
	Inertia.get(
		"/employees",
		{ search: value },
		{
			preserveState: true,
			replace: true,
		}
	);
});
</script>

<template>
	<Head title="Employee" />

	<BreezeAuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Employees
			</h2>
		</template>

		<div class="py-6">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-sm">
					<div class="flex items-center justify-center w-full">
						<div class="relative w-1/2 m-4 p-4">
							<Link
								:href="route('dashboard')"
								class="text-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
							>
								New Employee
							</Link>
						</div>
						<div class="relative w-1/2 m-4">
							<div
								class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
							>
								<svg
									aria-hidden="true"
									class="w-5 h-5 text-gray-500 dark:text-gray-400"
									fill="none"
									stroke="currentColor"
									viewBox="0 0 24 24"
									xmlns="http://www.w3.org/2000/svg"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
									></path>
								</svg>
							</div>
							<input
								type="search"
								v-model="search"
								class="w-full block p-4 pl-10 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
								placeholder="Search by ID, first, middle or last name......"
								required
							/>
						</div>
					</div>
					<div class="m-4">
						<table
							class="table-auto w-full text-center border-collapse"
						>
							<thead>
								<tr>
									<th
										class="p-4 border-zinc-900 bg-zinc-900 text-white border-y-2"
									>
										Employee ID
									</th>
									<th
										class="p-4 border-zinc-900 bg-zinc-900 text-white border-y-2"
									>
										Full Name
									</th>
									<th
										class="p-4 border-zinc-900 bg-zinc-900 text-white border-y-2"
									>
										Position
									</th>
									<th
										class="p-4 border-zinc-900 bg-zinc-900 text-white border-y-2"
									></th>
								</tr>
							</thead>
							<tbody>
								<tr
									v-for="employee in employees.data"
									:key="employee.id"
								>
									<td class="p-3 border-zinc-900 border-b">
										{{ employee.employee_id }}
									</td>
									<td class="p-3 border-zinc-900 border-b">
										{{ employee.first_name }}
										{{ employee.middle_name }}
										{{ employee.last_name }}
									</td>
									<td class="p-3 border-zinc-900 border-b">
										{{ employee.position }}
									</td>
									<td
										class="p-3 border-zinc-900 border-b gap-2"
									>
										<Link
											:href="
												route(
													'employees.show',
													employee.id
												)
											"
											class="text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
											>View</Link
										>
										<Link
											:href="
												route(
													'employees.show',
													employee.id
												)
											"
											class="text-center px-4 py-2 bg-orange-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
											>Edit</Link
										>
										<button
											@click="deleteEmployee(employee.id)"
											class="text-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
										>
											Delete
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<Pagination
						:first_page_url="employees.first_page_url"
						:from="employees.from"
						:last_page="employees.last_page"
						:last_page_url="employees.last_page_url"
						:links="employees.links"
						:next_page_url="employees.next_page_url"
						:prev_page_url="employees.prev_page_url"
						:to="employees.to"
						:total="employees.total"
					/>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>
