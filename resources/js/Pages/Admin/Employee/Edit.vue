<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeInputError from "@/Components/InputError.vue";
import BreezeLabel from "@/Components/Label.vue";
import Select from "@/Components/Select.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";

let props = defineProps({
	employee: Object,
});

const formatDate = (string_date) => {
	return string_date.substring(0, 10);
};

const genders = [
	{ label: "Male", value: "M" },
	{ label: "Female", value: "F" },
];
let form = useForm({
	employee_id: props.employee.employee_id,
	first_name: props.employee.first_name,
	middle_name: props.employee.middle_name,
	last_name: props.employee.last_name,
	birth_date: formatDate(props.employee.birth_date),
	gender: props.employee.gender,
	email: props.employee.email,
	position: props.employee.position,
	salary: props.employee.salary,
	profile_pic: props.employee.profile_pic,
	_method: "PUT",
});

const submit = () => {
	form.post(`/employees/${props.employee.id}`, {
		forceFormData: true,
	});
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
				> Edit >
				{{ employee.employee_id }}
			</h2>
		</template>
		<div
			class="w-full bg-white rounded-lg border border-gray-200 shadow-md mx-auto my-6"
		>
			<div class="max-w-screen-sm p-4 md:p-7 mx-auto">
				<form @submit.prevent="submit">
					<div>
						<BreezeLabel for="employee_id" value="Employee ID" />
						<BreezeInput
							id="employee_id"
							type="text"
							class="mt-1 block w-full"
							v-model="form.employee_id"
							readonly
							autofocus
							autocomplete="employee_id"
							placeholder="Auto Generated"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel for="email" value="Email Address" />
						<BreezeInput
							id="email"
							type="email"
							class="mt-1 block w-full"
							v-model="form.email"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.email"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel for="position" value="Position" />
						<BreezeInput
							id="position"
							type="text"
							class="mt-1 block w-full"
							v-model="form.position"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.position"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel for="salary" value="Salary" />
						<BreezeInput
							id="salary"
							type="number"
							step="0.01"
							min="0.00"
							class="mt-1 block w-full"
							v-model="form.salary"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.salary"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel
							for="profile_pic"
							value="Profile Picture"
						/>
						<input
							@input="form.profile_pic = $event.target.files[0]"
							id="profile_pic"
							type="file"
							accept=".jpg,.jpeg, .png"
							class="mt-1 block w-full"
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.profile_pic"
						/>
					</div>

					<div
						class="mt-6 text-center py-3 bg-gray-900 text-white font-semibold"
					>
						Personal Details
					</div>
					<div class="mt-4">
						<BreezeLabel for="last_name" value="Last Name" />
						<BreezeInput
							id="last_name"
							type="text"
							class="mt-1 block w-full"
							v-model="form.last_name"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.last_name"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel for="first_name" value="First Name" />
						<BreezeInput
							id="first_name"
							type="text"
							class="mt-1 block w-full"
							v-model="form.first_name"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.first_name"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel for="middle_name" value="Middle Name" />
						<BreezeInput
							id="middle_name"
							type="text"
							class="mt-1 block w-full"
							v-model="form.middle_name"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.middle_name"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel for="gender" value="Gender" />
						<Select
							id="gender"
							class="mt-1 block w-full"
							v-model="form.gender"
							:options="genders"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.gender"
						/>
					</div>
					<div class="mt-4">
						<BreezeLabel for="birth_date" value="Birth Date" />
						<BreezeInput
							id="birth_date"
							type="date"
							class="mt-1 block w-full"
							v-model="form.birth_date"
							required
						/>
						<BreezeInputError
							class="mt-2"
							:message="form.errors.birth_date"
						/>
					</div>
					<div
						class="flex items-center flex-col justify-center mt-4 text-center"
					>
						<BreezeButton
							class="my-4 w-full bg-blue-600"
							:class="{ 'opacity-25': form.processing }"
							:disabled="form.processing"
						>
							Update
						</BreezeButton>
					</div>
				</form>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>
