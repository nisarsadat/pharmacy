<template>
    <v-container class="form-wrapper">
        <v-card class="w-full mx-auto" max-width="800">
            <!-- Header -->
            <v-card-title class="px-6 py-3 d-flex justify-space-between">
                <h2>ساختن محصول</h2>
            </v-card-title>

            <!-- Form -->
            <v-card-text>
                <v-form ref="formRef">
                    <v-row dense>
                        <v-col cols="12">
                            <div class="image-upload-wrapper">
                                <!-- Hidden input -->
                                <input
                                    ref="fileInput"
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    style="display: none"
                                    @change="onImageChange"
                                />

                                <!-- Upload box -->
                                  
                                    <div class="image-box">
                                        <div
                                            v-if="imagePreviews.length"
                                            class="preview-grid"
                                        >
                                            <v-img
                                                v-for="(
                                                    img, index
                                                ) in imagePreviews"
                                                :key="index"
                                                :src="img"
                                                height="100"
                                                width="100"
                                                cover
                                                class="rounded-lg"
                                            />
                                        </div>

                                        <div v-else class="placeholder">
                                            <v-icon size="40"
                                                >mdi-image-plus</v-icon
                                            >
                                            <p>Click to upload images</p>

                                            <v-btn
                                                color="primary"
                                                @click="triggerFile"
                                            >
                                                Upload Images
                                            </v-btn>
                                        </div>
                                    </div>
                                </div>
                        </v-col>
                        <!-- thsi is for 5 images -->
                        <!-- thsi is for 5 images -->
                        <v-col cols="12">
                            <v-file-input
                                v-model="formData.images"
                                label="تصاویر محصول (حداکثر 5 عکس)"
                                multiple
                                accept="image/*"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.maxImages]"
                                show-size
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.name"
                                label="اسم"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.main_price"
                                label="قيمت اصلي"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.sale_price"
                                label="قيمت فروش"
                                type="number"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.product_quantity"
                                label="مقدار محصول  "
                                type="number"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.product_company"
                                label=":کارخانه محصول  "
                                type="text"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-select
                                v-model="formData.product_type_id"
                                label="نوعیت محصول"
                                :items="
                                    WareHouseRepository.ProductTypesForDropDown
                                "
                                item-title="label"
                                item-value="value"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-autocomplete
                                v-model="formData.warehouse_id"
                                label="گدام"
                                :items="
                                    WareHouseRepository.warehouseForDropDown
                                "
                                item-title="label"
                                item-value="value"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>

                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.date"
                                label="تاریخ"
                                type="date"
                                variant="outlined"
                                density="compact"
                                :rules="[rules.required]"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.expire_date"
                                label=" تاریخ انقضا"
                                type="date"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.product_date"
                                label=" تاریخ محصول"
                                type="date"
                                variant="outlined"
                                density="compact"
                            />
                        </v-col>
                    </v-row>

                    <v-textarea
                        v-model="formData.note"
                        label="نوت"
                        variant="outlined"
                        density="compact"
                    />
                </v-form>
            </v-card-text>

            <!-- Actions -->
            <v-card-actions class="px-6 pb-6">
                <v-btn color="light-blue-darken-1" @click="createproducts">
                    ثبت کردن
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
let WareHouseRepository = useWareHouseRepository();
import { useRouter } from "vue-router";

// this is for 5 images
const rules = {
    required: (value) => !!value || "Required.",
    maxImages: (value) =>
        !value || value.length <= 5 || "You can upload maximum 5 images",
};

const fileInput = ref(null);
const imagePreviews = ref([]);

const router = useRouter();
const formRef = ref(null);

const formData = reactive({
    name: "",
    main_price: "",
    sale_price: "",
    product_quantity: "",
    product_company: "",
    date: "",
    expire_date: "",
    product_date: "",
    warehouse_id: "",
    product_type_id: "",
    note: " ",
    images: [], //this is for 5 images
});
const triggerFile = () => {
    fileInput.value.click();
};

const onImageChange = (event) => {
    const files = Array.from(event.target.files);

    if (!files.length) return;

    // merge old + new images
    const allImages = [...formData.images, ...files];

    // limit to 5
    if (allImages.length > 5) {
        alert("Maximum 5 images allowed");
        return;
    }

    formData.images = allImages;

    // previews
    imagePreviews.value = formData.images.map((file) =>
        URL.createObjectURL(file)
    );

    // reset input so same image can be selected again
    event.target.value = "";
};

// Example account types, you can modify this

const createproducts = async () => {
    const { valid } = await formRef.value.validate();

    if (valid) {
        let data = new FormData();

        // normal fields
        Object.keys(formData).forEach((key) => {
            if (key !== "images") {
                data.append(key, formData[key]);
            }
        });

        // images array
        if (formData.images && formData.images.length) {
            formData.images.forEach((file, index) => {
                data.append(`images[${index}]`, file);
            });
        }

        await WareHouseRepository.createproduct(data);

        router.push("/products");
    }
};

onMounted(() => {
    WareHouseRepository.fetchwarehouseForDropDowns();
    WareHouseRepository.fetchProductTypesForDropDowns();
});
</script>
<style scoped>
.preview-grid {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    padding: 10px;
}
.custom-image-input {
    border: 2px dashed #90caf9;
    border-radius: 12px;
    padding: 10px;
    background: #f5faff;
    transition: all 0.3s ease;
}

.custom-image-input:hover {
    border-color: #1e88e5;
    background: #e3f2fd;
}

.custom-image-input .v-field {
    background: transparent;
}

.custom-image-input .v-chip {
    background: #1e88e5 !important;
    color: white !important;
}
.image-upload-wrapper {
    cursor: pointer;
}

.image-box {
    border: 2px dashed #90caf9;
    border-radius: 12px;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5faff;
    transition: 0.3s;
}

.image-box:hover {
    border-color: #1e88e5;
    background: #e3f2fd;
}

.placeholder {
    text-align: center;
    color: #1e88e5;
}
</style>
