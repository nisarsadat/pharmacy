<template>
  <v-dialog v-model="dialog" max-width="500px">
    <v-card>
      <v-card-title>
        {{ editedItem ? "ویرایش حساب" : "ایجاد حساب" }}
      </v-card-title>

      <v-card-text>
        <v-text-field v-model="form.name" label="نام" />
        <v-text-field v-model="form.email" label="ایمیل" />
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn text @click="close">لغو</v-btn>
        <v-btn color="primary" @click="save">ذخیره</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { watch, ref, computed } from "vue";
import accountRepository from "@/repositories/accountRepository";

const props = defineProps({
  modelValue: Boolean,
  editedItem: Object,
});

const emit = defineEmits(["update:modelValue", "saved"]);

// ✅ FIX HERE (computed for v-model)
const dialog = computed({
  get: () => props.modelValue,
  set: (val) => emit("update:modelValue", val),
});

const form = ref({
  name: "",
  email: "",
});

watch(
  () => props.editedItem,
  (val) => {
    if (val) {
      form.value = { ...val };
    } else {
      form.value = { name: "", email: "" };
    }
  },
  { immediate: true }
);

function close() {
  dialog.value = false;
}

function save() {
  if (props.editedItem) {
    accountRepository.update(props.editedItem.id, form.value).then(() => {
      emit("saved");
      close();
    });
  } else {
    accountRepository.create(form.value).then(() => {
      emit("saved");
      close();
    });
  }
}
</script>