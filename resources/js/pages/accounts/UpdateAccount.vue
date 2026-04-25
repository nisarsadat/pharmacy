<template>
    <v-dialog
        v-model="AccountRepository.updateDialog"
        width="720"
        transition="dialog-bottom-transition"
        class="form-wrapper"
    >
        <v-card class="update-dialog-card" rounded="xl" elevation="18">
            <v-card-title class="dialog-header px-6 py-5">
                <div class="d-flex align-center ga-3">
                    <v-avatar color="primary" variant="tonal" size="44">
                        <v-icon color="primary" icon="mdi-account-edit-outline" />
                    </v-avatar>

                    <div>
                        <div class="text-subtitle-1 font-weight-bold">ویرایش حساب</div>
                        <div class="text-caption text-medium-emphasis">
                            اطلاعات مورد نظر را اصلاح کنید
                        </div>
                    </div>
                </div>

                <v-spacer />

                <v-btn
                    icon="mdi-close"
                    variant="text"
                    density="comfortable"
                    class="close-btn"
                    @click="AccountRepository.updateDialog = false"
                />
            </v-card-title>

            <v-divider />

            <v-card-text class="pa-6">
                <v-sheet class="info-banner mb-5 pa-4" rounded="lg" border>
                    <div class="d-flex align-center ga-3">
                        <v-icon color="primary">mdi-information-outline</v-icon>
                        <div class="text-body-2 text-medium-emphasis">
                            تمام فیلدهای ضروری را تکمیل کنید و سپس تغییرات را ثبت کنید.
                        </div>
                    </div>
                </v-sheet>

                <v-form ref="formRef">
                    <v-row dense class="ga-2">
                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.name"
                                label="اسم*"
                                variant="outlined"
                                density="comfortable"
                                prepend-inner-icon="mdi-account-outline"
                                :rules="[rules.required]"
                                hide-details="auto"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.price"
                                label="قیمت*"
                                variant="outlined"
                                density="comfortable"
                                prepend-inner-icon="mdi-cash"
                                :rules="[rules.required]"
                                hide-details="auto"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.date"
                                label="تاریخ*"
                                type="date"
                                variant="outlined"
                                density="comfortable"
                                prepend-inner-icon="mdi-calendar-month-outline"
                                :rules="[rules.required]"
                                hide-details="auto"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                v-model="formData.account_type"
                                :items="accountTypes"
                                label="نوعیت اکونت*"
                                variant="outlined"
                                density="comfortable"
                                prepend-inner-icon="mdi-shape-outline"
                                :rules="[rules.required]"
                                hide-details="auto"
                            />
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                v-model="formData.note"
                                label="نکته"
                                variant="outlined"
                                density="comfortable"
                                prepend-inner-icon="mdi-note-text-outline"
                                rows="4"
                                auto-grow
                                hide-details="auto"
                            />
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>

            <v-divider />

            <v-card-actions class="px-6 py-4 dialog-actions">
                <v-btn
                    variant="text"
                    color="grey-darken-1"
                    class="px-5 cancel-btn"
                    @click="AccountRepository.updateDialog = false"
                >
                    لغو
                </v-btn>

                <v-spacer />

                <v-btn
                    color="primary"
                    variant="flat"
                    class="px-6 submit-btn"
                    @click="updateAccount"
                >
                    <v-icon start>mdi-content-save-outline</v-icon>
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { reactive, ref, watch } from "vue";
import { useAccountRepository } from "../../repositories/AccountRepository";

const AccountRepository = useAccountRepository();
const formRef = ref(null);

const formData = reactive({
    id: "",
    name: "",
    price: "",
    date: "",
    note: "",
    account_type: "",
});

watch(
    () => AccountRepository.account,
    (newAccount) => {
        if (newAccount) {
            Object.assign(formData, newAccount);
        }
    },
    { immediate: true },
);

const accountTypes = ["Bank", "Cash", "Digital Wallet"];

const rules = {
    required: (value) => !!value || "Required.",
};

const updateAccount = async () => {
    formRef.value.validate().then((valid) => {
        if (valid) {
            AccountRepository.updateAccount(formData.id, formData);
        }
    });
};
</script>

<style scoped>
.update-dialog-card {
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.08);
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

.dialog-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.09), rgba(25, 118, 210, 0.02));
}

.close-btn {
    border-radius: 12px;
}

.close-btn:hover {
    background: rgba(0, 0, 0, 0.04);
}

.info-banner {
    background: rgba(25, 118, 210, 0.03);
    border-color: rgba(25, 118, 210, 0.12);
}

:deep(.v-field) {
    border-radius: 14px;
}

:deep(.v-field__input) {
    font-size: 0.95rem;
}

.dialog-actions {
    background: rgba(255, 255, 255, 0.72);
    backdrop-filter: blur(8px);
}

.cancel-btn {
    border-radius: 14px;
    text-transform: none;
    letter-spacing: 0;
    font-weight: 500;
}

.submit-btn {
    border-radius: 14px;
    font-weight: 600;
    text-transform: none;
    letter-spacing: 0;
    box-shadow: 0 10px 20px rgba(25, 118, 210, 0.22);
}

.submit-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 14px 26px rgba(25, 118, 210, 0.28);
}
</style>