<script setup>
import { onMounted, ref } from "vue";

defineProps(["modelValue", "options"]);

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
	if (input.value.hasAttribute("autofocus")) {
		input.value.focus();
	}
});
</script>

<template>
	<select
		:value="modelValue"
		ref="input"
		@change="$emit('update:modelValue', $event.target.value)"
		class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
	>
		<option selected value="">*Select*</option>
		<option
			v-for="option in options"
			:key="option.value"
			:value="option.value"
		>
			{{ option.label }}
		</option>
	</select>
</template>
