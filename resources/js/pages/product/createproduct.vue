<template>
    <v-container class="product-create-page" fluid dir="rtl">
        <v-card class="product-card mx-auto" max-width="1000" elevation="0">
            <div class="header-section">
                <div>
                    <h2 class="text-h5 font-weight-bold mb-1">
                        ساختن محصول جدید
                    </h2>
                    <p class="text-body-2 text-medium-emphasis mb-0">
                        معلومات محصول، گدام، نوعیت و تصاویر را وارد کنید.
                    </p>
                </div>

                <v-btn
                    color="grey-darken-1"
                    variant="tonal"
                    prepend-icon="mdi-arrow-left"
                    @click="router.push('/products')"
                >
                    برگشت
                </v-btn>
            </div>

            <v-divider />

            <v-card-text class="pa-6">
                <v-form ref="formRef" @submit.prevent="createProduct">
                    <v-row dense>
                        <!-- Images -->
                        <v-col cols="12">
                            <div class="section-title">
                                <v-icon size="20">mdi-image-multiple</v-icon>
                                تصاویر محصول
                            </div>

                            <div
                                class="upload-box"
                                :class="{ 'upload-box-error': imageError }"
                                @click="triggerFile"
                            >
                                <input
                                    ref="fileInput"
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    class="d-none"
                                    @change="onImageChange"
                                />

                                <template v-if="imagePreviews.length">
                                    <div class="preview-grid">
                                        <div
                                            v-for="(img, index) in imagePreviews"
                                            :key="index"
                                            class="preview-item"
                                            @click.stop
                                        >
                                            <v-img
                                                :src="img.url"
                                                height="120"
                                                width="120"
                                                cover
                                                class="rounded-lg"
                                            />

                                            <v-btn
                                                icon="mdi-close"
                                                size="x-small"
                                                color="red"
                                                class="remove-image-btn"
                                                @click="removeImage(index)"
                                            />
                                        </div>

                                        <button
                                            v-if="formData.images.length < 5"
                                            type="button"
                                            class="add-more-box"
                                            @click.stop="triggerFile"
                                        >
                                            <v-icon size="32">
                                                mdi-plus
                                            </v-icon>
                                            <span>عکس دیگر</span>
                                        </button>
                                    </div>
                                </template>

                                <template v-else>
                                    <div class="placeholder">
                                        <v-icon size="48" color="primary">
                                            mdi-image-plus
                                        </v-icon>

                                        <div class="font-weight-bold mt-2">
                                            برای انتخاب عکس کلیک کنید
                                        </div>

                                        <div class="text-body-2 text-medium-emphasis mt-1">
                                            حداکثر ۵ عکس انتخاب شده می‌تواند
                                        </div>

                                        <v-btn
                                            color="primary"
                                            class="mt-4"
                                            prepend-icon="mdi-upload"
                                            @click.stop="triggerFile"
                                        >
                                            انتخاب تصاویر
                                        </v-btn>
                                    </div>
                                </template>
                            </div>

                            <div
                                v-if="imageError"
                                class="text-error text-caption mt-2"
                            >
                                {{ imageError }}
                            </div>
                        </v-col>

                        <!-- Product Info -->
                        <v-col cols="12">
                            <div class="section-title mt-4">
                                <v-icon size="20">mdi-package-variant</v-icon>
                                معلومات اصلی محصول
                            </div>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.name"
                                label="اسم محصول"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-tag"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.product_company"
                                label="شرکت / کارخانه محصول"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-factory"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.main_price"
                                label="قیمت اصلی"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-cash"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.sale_price"
                                label="قیمت فروش"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-sale"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field
                                v-model="formData.product_quantity"
                                label="مقدار محصول"
                                type="number"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-counter"
                                :rules="[rules.required, rules.positiveNumber]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select
                                v-model="formData.product_type_id"
                                label="نوعیت محصول"
                                :items="WareHouseRepository.ProductTypesForDropDown"
                                item-title="label"
                                item-value="value"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-shape"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-autocomplete
                                v-model="formData.warehouse_id"
                                label="گدام"
                                :items="WareHouseRepository.warehouseForDropDown"
                                item-title="label"
                                item-value="value"
                                variant="outlined"
                                density="compact"
                                prepend-inner-icon="mdi-warehouse"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <!-- Dates -->
                        <v-col cols="12">
                            <div class="section-title mt-4">
                                <v-icon size="20">mdi-calendar</v-icon>
                                تاریخ‌ها
                            </div>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.date"
                                label="تاریخ ثبت"
                                type="date"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.produced_date"
                                label="تاریخ تولید"
                                type="date"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="formData.expire_date"
                                label="تاریخ انقضا"
                                type="date"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="12">
                            <v-textarea
                                v-model="formData.note"
                                label="نوت"
                                variant="outlined"
                                density="compact"
                                rows="3"
                                prepend-inner-icon="mdi-note-text"
                            />
                        </v-col>
                    </v-row>

                    <v-alert
                        v-if="serverError"
                        type="error"
                        variant="tonal"
                        class="mt-3"
                        density="compact"
                    >
                        {{ serverError }}
                    </v-alert>

                    <div class="actions">
                        <v-btn
                            color="grey"
                            variant="tonal"
                            :disabled="loading"
                            @click="resetForm"
                        >
                            پاک کردن
                        </v-btn>

                        <v-btn
                            color="primary"
                            type="submit"
                            :loading="loading"
                            prepend-icon="mdi-content-save"
                        >
                            ثبت کردن
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted, onBeforeUnmount } from "vue";
import { useRouter } from "vue-router";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

const router = useRouter();
const WareHouseRepository = useWareHouseRepository();

const formRef = ref(null);
const fileInput = ref(null);
const imageError = ref("");
const serverError = ref("");
const loading = ref(false);
const imagePreviews = ref([]);

const formData = reactive({
    name: "",
    main_price: "",
    sale_price: "",
    product_quantity: "",
    product_company: "",
    date: "",
    expire_date: "",
    produced_date: "",
    warehouse_id: "",
    product_type_id: "",
    note: "",
    images: [],
});

const rules = {
    required: (value) => !!value || "این فیلد ضروری است.",
    positiveNumber: (value) => {
        if (value === "" || value === null || value === undefined) {
            return true;
        }

        return Number(value) >= 0 || "عدد باید منفی نباشد.";
    },
};

const triggerFile = () => {
    fileInput.value?.click();
};

const revokePreviews = () => {
    imagePreviews.value.forEach((img) => {
        URL.revokeObjectURL(img.url);
    });
};

const rebuildPreviews = () => {
    revokePreviews();

    imagePreviews.value = formData.images.map((file) => ({
        name: file.name,
        url: URL.createObjectURL(file),
    }));
};

const onImageChange = (event) => {
    imageError.value = "";

    const selectedFiles = Array.from(event.target.files || []);

    if (!selectedFiles.length) {
        return;
    }

    const validImages = selectedFiles.filter((file) =>
        file.type.startsWith("image/")
    );

    if (validImages.length !== selectedFiles.length) {
        imageError.value = "لطفاً فقط فایل عکس انتخاب کنید.";
        event.target.value = "";
        return;
    }

    const nextImages = [...formData.images, ...validImages];

    if (nextImages.length > 5) {
        imageError.value = "حداکثر ۵ عکس انتخاب شده می‌تواند.";
        event.target.value = "";
        return;
    }

    formData.images = nextImages;
    rebuildPreviews();

    event.target.value = "";
};

const removeImage = (index) => {
    formData.images.splice(index, 1);
    rebuildPreviews();

    if (formData.images.length <= 5) {
        imageError.value = "";
    }
};

const buildFormData = () => {
    const data = new FormData();

    data.append("name", formData.name);
    data.append("main_price", formData.main_price);
    data.append("sale_price", formData.sale_price);
    data.append("product_quantity", formData.product_quantity);
    data.append("product_company", formData.product_company || "");
    data.append("date", formData.date);
    data.append("expire_date", formData.expire_date || "");
    data.append("produced_date", formData.produced_date || "");
    data.append("warehouse_id", formData.warehouse_id);
    data.append("product_type_id", formData.product_type_id);
    data.append("note", formData.note || "");

    formData.images.forEach((file) => {
        data.append("images[]", file);
    });

    return data;
};

const createProduct = async () => {
    serverError.value = "";
    imageError.value = "";

    const result = await formRef.value?.validate();

    if (!result?.valid) {
        return;
    }

    if (formData.images.length > 5) {
        imageError.value = "حداکثر ۵ عکس انتخاب شده می‌تواند.";
        return;
    }

    loading.value = true;

    try {
        const data = buildFormData();

        await WareHouseRepository.createproduct(data);

        router.push("/products");
    } catch (error) {
        serverError.value =
            error?.response?.data?.message ||
            "مشکل در ثبت محصول رخ داد. لطفاً دوباره کوشش کنید.";
    } finally {
        loading.value = false;
    }
};

const resetForm = () => {
    formData.name = "";
    formData.main_price = "";
    formData.sale_price = "";
    formData.product_quantity = "";
    formData.product_company = "";
    formData.date = "";
    formData.expire_date = "";
    formData.produced_date = "";
    formData.warehouse_id = "";
    formData.product_type_id = "";
    formData.note = "";
    formData.images = [];

    imageError.value = "";
    serverError.value = "";

    revokePreviews();
    imagePreviews.value = [];

    formRef.value?.resetValidation();
};

onMounted(async () => {
    await Promise.all([
        WareHouseRepository.fetchwarehouseForDropDowns(),
        WareHouseRepository.fetchProductTypesForDropDowns(),
    ]);
});

onBeforeUnmount(() => {
    revokePreviews();
});
</script>

<style scoped>
.product-create-page {
    min-height: 100%;
    padding: 28px;
    background:
        radial-gradient(circle at top right, rgba(103, 58, 183, 0.12), transparent 32%),
        linear-gradient(180deg, #fafafa, #f5f7fb);
}

.product-card {
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(120, 120, 120, 0.16);
}

.header-section {
    padding: 22px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    background: linear-gradient(135deg, rgba(103, 58, 183, 0.08), rgba(33, 150, 243, 0.06));
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-weight: 700;
    color: #4527a0;
}

.upload-box {
    min-height: 190px;
    border: 2px dashed #b39ddb;
    border-radius: 20px;
    background: #fbfaff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px;
    cursor: pointer;
    transition: 0.2s ease;
}

.upload-box:hover {
    border-color: #673ab7;
    background: #f7f2ff;
}

.upload-box-error {
    border-color: #f44336;
    background: #fff5f5;
}

.placeholder {
    text-align: center;
}

.preview-grid {
    width: 100%;
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    align-items: center;
}

.preview-item {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.remove-image-btn {
    position: absolute;
    top: 6px;
    left: 6px;
}

.add-more-box {
    width: 120px;
    height: 120px;
    border: 2px dashed #b39ddb;
    border-radius: 14px;
    background: white;
    color: #673ab7;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
}

.add-more-box:hover {
    background: #f7f2ff;
}

.actions {
    margin-top: 22px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}
</style>