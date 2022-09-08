<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

let props = defineProps({
	employee: Object,
});

const deleteEmployee = (id) => {
	let c = confirm("Are you sure to delete this employee Record");
	if (c) {
		Inertia.delete(`/employees/${id}`);
	}
};

const formatDate = (string_date) => {
	return string_date.substring(0, 10);
};
const getOrigin = () => {
	return window.location.origin;
};
</script>

<template>
	<Head title="Employee" />

	<BreezeAuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				<Link
					:href="route('employees')"
					class="underline-offset-4 underline"
					>Employees</Link
				>
				> Read >
				{{ employee.employee_id }}
			</h2>
		</template>
		<div
			class="grid grid-cols-1 md:grid-cols-2 bg-white rounded-lg border border-gray-200 shadow-md mx-auto my-6"
		>
			<div class="flex flex-col items-center pt-10">
				<img
					class="mb-3 w-24 h-24 rounded-full shadow-lg"
					:src="
						employee.profile_pic
							? `${getOrigin()}${employee.profile_pic}`
							: employee.gender == 'M'
							? 'https://png.pngtree.com/png-vector/20190710/ourmid/pngtree-user-vector-avatar-png-image_1541962.jpg'
							: 'https://png.pngtree.com/png-vector/20191116/ourlarge/pngtree-business-office-girl-avatar-icon-vector-download-png-image_1991055.jpg'
					"
					alt="Profile Pic"
				/>
				<h5 class="mb-1 text-xl font-medium text-gray-900">
					{{ employee.first_name }}
					{{ employee.middle_name.substring(0, 1) + "." }}
					{{ employee.last_name }}
				</h5>
				<span class="text-sm text-gray-500">{{
					employee.position
				}}</span>

				<div class="flex flex-col mt-4 md:mt-6 px-5 w-full">
					<ul
						role="list"
						class="divide-y divide-gray-200 text-center md:text-left"
					>
						<li class="py-2">
							<div class="flex items-center space-x-4">
								<div class="flex-1 min-w-0">
									<p
										class="text-sm text-gray-500 pb-1 truncate"
									>
										Employee ID
									</p>
									<p
										class="text-sm text-gray-900 truncate font-bold"
									>
										{{ employee.employee_id }}
									</p>
								</div>
							</div>
						</li>
						<li class="py-2">
							<div class="flex items-center space-x-4">
								<div class="flex-1 min-w-0">
									<p
										class="text-sm text-gray-500 pb-1 truncate"
									>
										Position
									</p>
									<p
										class="text-sm text-gray-900 truncate font-bold"
									>
										{{ employee.position }}
									</p>
								</div>
							</div>
						</li>
						<li class="py-2">
							<div class="flex items-center space-x-4">
								<div class="flex-1 min-w-0">
									<p
										class="text-sm text-gray-500 pb-1 truncate"
									>
										Salary
									</p>
									<p
										class="text-sm text-gray-900 truncate font-bold"
									>
										&#8369; {{ employee.salary }}
									</p>
								</div>
							</div>
						</li>
						<li class="py-2">
							<div class="flex items-center space-x-4">
								<div class="flex-1 min-w-0">
									<p
										class="text-sm text-gray-500 pb-1 truncate"
									>
										Status
									</p>
									<p
										class="text-sm text-gray-900 truncate font-bold"
									>
										{{
											employee.deleted_at
												? "INACTIVE"
												: "ACTIVE"
										}}
									</p>
								</div>
							</div>
						</li>
						<li></li>
					</ul>
				</div>
			</div>

			<div class="flex flex-col mt-5 md:mt-10 px-5">
				<ul
					role="list"
					class="divide-y divide-gray-200 text-center md:text-left"
				>
					<li class="py-2 bg-gray-800">
						<div class="flex items-center space-x-4">
							<div class="flex-1 min-w-0">
								<h3
									class="text-sm text-white pb-1 truncate font-extrabold text-center"
								>
									Personal Details
								</h3>
							</div>
						</div>
					</li>
					<li class="py-2">
						<div class="flex items-center space-x-4">
							<div class="flex-1 min-w-0">
								<p class="text-sm text-gray-500 pb-1 truncate">
									Last Name
								</p>
								<p
									class="text-sm text-gray-900 truncate font-bold"
								>
									{{ employee.last_name }}
								</p>
							</div>
						</div>
					</li>
					<li class="py-2">
						<div class="flex items-center space-x-4">
							<div class="flex-1 min-w-0">
								<p class="text-sm text-gray-500 pb-1 truncate">
									First Name
								</p>
								<p
									class="text-sm text-gray-900 truncate font-bold"
								>
									{{ employee.first_name }}
								</p>
							</div>
						</div>
					</li>
					<li class="py-2">
						<div class="flex items-center space-x-4">
							<div class="flex-1 min-w-0">
								<p class="text-sm text-gray-500 pb-1 truncate">
									Middle Name
								</p>
								<p
									class="text-sm text-gray-900 truncate font-bold"
								>
									{{ employee.middle_name }}
								</p>
							</div>
						</div>
					</li>
					<li class="py-2">
						<div class="flex items-center space-x-4">
							<div class="flex-1 min-w-0">
								<p class="text-sm text-gray-500 pb-1 truncate">
									Birth Date
								</p>
								<p
									class="text-sm text-gray-900 truncate font-bold"
								>
									{{ formatDate(employee.birth_date) }}
								</p>
							</div>
						</div>
					</li>
					<li class="py-2">
						<div class="flex items-center space-x-4">
							<div class="flex-1 min-w-0">
								<p class="text-sm text-gray-500 pb-1 truncate">
									Gender
								</p>
								<p
									class="text-sm text-gray-900 truncate font-bold"
								>
									{{
										employee.gender == "F"
											? "Female"
											: "Male"
									}}
								</p>
							</div>
						</div>
					</li>
					<li></li>
				</ul>

				<div class="flex flex-col gap-2 my-6">
					<Link
						:href="route('dashboard')"
						class="text-center px-4 py-2 bg-orange-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase w-full mb-4"
					>
						Edit
					</Link>
					<button
						@click="deleteEmployee(employee.id)"
						class="text-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase w-full"
					>
						Delete
					</button>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>
