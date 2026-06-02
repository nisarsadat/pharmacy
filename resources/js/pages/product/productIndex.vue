<template>
    <v-container fluid class="products-page" dir="rtl">
        <div class="page-header">
            <div>
                <h1 class="text-h5 font-weight-bold mb-1">لیست محصولات</h1>
                <p class="text-body-2 text-medium-emphasis mb-0">
                    همه محصولات دواخانه را به شکل کارت مشاهده کنید.
                </p>
            </div>

            <v-btn
                color="primary"
                rounded="xl"
                prepend-icon="mdi-plus"
                @click="$router.push({ name: 'products.create' })"
            >
                محصول جدید
            </v-btn>
        </div>

        <v-card class="search-card mb-5" elevation="0" rounded="xl">
            <v-card-text>
                <v-row dense align="center">
                    <v-col cols="12" md="5">
                        <v-text-field
                            v-model="search"
                            label="جستجوی محصول"
                            placeholder="اسم، شرکت، گدام یا نوعیت محصول..."
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            density="compact"
                            clearable
                            hide-details
                        />
                    </v-col>

                    <v-col cols="12" md="7">
                        <div class="stats-row">
                            <v-chip color="primary" variant="tonal">
                                تعداد محصولات: {{ filteredProducts.length }}
                            </v-chip>

                            <v-chip color="green" variant="tonal">
                                موجودی کل: {{ totalQuantity }}
                            </v-chip>

                            <v-chip color="orange" variant="tonal">
                                نزدیک به انقضا: {{ expiringProductsCount }}
                            </v-chip>
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>

        <div v-if="WareHouseRepository.loading" class="loading-box">
            <v-progress-circular indeterminate color="primary" size="48" />
            <div class="mt-3 text-body-2 text-medium-emphasis">
                محصولات در حال بارگذاری است...
            </div>
        </div>

        <v-card
            v-else-if="!filteredProducts.length"
            class="empty-card"
            elevation="0"
            rounded="xl"
        >
            <v-icon size="64" color="grey">mdi-package-variant-closed</v-icon>
            <h3 class="mt-3 mb-1">هیچ محصولی پیدا نشد</h3>
            <p class="text-body-2 text-medium-emphasis">
                محصول جدید ثبت کنید یا متن جستجو را تغییر دهید.
            </p>
        </v-card>

        <v-row v-else dense>
            <v-col
                v-for="product in paginatedProducts"
                :key="product.id"
                cols="12"
                sm="6"
                lg="4"
                xl="3"
            >
                <v-card class="product-card" elevation="0" rounded="xl">
                    <div class="image-area">
                        <v-carousel
                            v-if="product.images && product.images.length"
                            height="220"
                            hide-delimiter-background
                            show-arrows="hover"
                            cycle
                            interval="3500"
                        >
                            <v-carousel-item
                                v-for="image in product.images"
                                :key="image.id || image.image"
                            >
                                <v-img
                                    :src="getImageUrl(image.image)"
                                    height="220"
                                    cover
                                />
                            </v-carousel-item>
                        </v-carousel>

                        <div v-else class="no-image">
                            <v-icon size="58" color="grey-lighten-1">
                                mdi-image-off-outline
                            </v-icon>
                            <span>عکس موجود نیست</span>
                        </div>

                        <v-chip
                            class="quantity-chip"
                            :color="
                                Number(product.product_quantity) > 0
                                    ? 'green'
                                    : 'red'
                            "
                            variant="flat"
                            size="small"
                        >
                            {{
                                Number(product.product_quantity || 0) > 0
                                    ? "موجود"
                                    : "تمام شده"
                            }}
                        </v-chip>
                    </div>

                    <v-card-text class="pa-4">
                        <div
                            class="d-flex justify-space-between align-start ga-3 mb-3"
                        >
                            <div>
                                <h3 class="product-title">
                                    {{ product.name || "بدون اسم" }}
                                </h3>

                                <div
                                    class="text-caption text-medium-emphasis mt-1"
                                >
                                    {{
                                        product.product_company ||
                                        "شرکت ثبت نشده"
                                    }}
                                </div>
                            </div>

                            <v-menu>
                                <template #activator="{ props }">
                                    <v-btn
                                        v-bind="props"
                                        icon="mdi-dots-vertical"
                                        variant="text"
                                        size="small"
                                    />
                                </template>

                                <v-list density="compact">
                                    <v-list-item
                                        prepend-icon="mdi-eye-outline"
                                        title="دیدن جزئیات"
                                        @click="goToDetails(product.id)"
                                    />

                                    <v-list-item
                                        prepend-icon="mdi-square-edit-outline"
                                        title="ویرایش"
                                        @click="
                                            $router.push({
                                                name: 'products.edit',
                                                params: { id: product.id },
                                            })
                                        "
                                    />

                                    <v-list-item
                                        prepend-icon="mdi-delete-outline"
                                        title="حذف کردن"
                                        class="text-red"
                                        @click="openDeleteDialog(product)"
                                    />
                                </v-list>
                            </v-menu>
                        </div>

                        <div class="info-grid">
                            <div class="info-box">
                                <span>قیمت اصلی</span>
                                <strong>
                                    {{ formatMoney(product.main_price) }}
                                </strong>
                            </div>

                            <div class="info-box">
                                <span>قیمت فروش</span>
                                <strong>
                                    {{ formatMoney(product.sale_price) }}
                                </strong>
                            </div>

                            <div class="info-box">
                                <span>مقدار</span>
                                <strong>
                                    {{ product.product_quantity || 0 }}
                                </strong>
                            </div>

                            <div class="info-box">
                                <span>تاریخ انقضا</span>
                                <strong
                                    :class="expireClass(product.expire_date)"
                                >
                                    {{ product.expire_date || "ثبت نشده" }}
                                </strong>
                            </div>
                        </div>

                        <div class="relation-row mt-4">
                            <v-chip
                                size="small"
                                variant="tonal"
                                color="deep-purple"
                            >
                                گدام:
                                {{
                                    product.warehouse?.name ||
                                    product.warehouse_id ||
                                    "نامعلوم"
                                }}
                            </v-chip>

                            <v-chip size="small" variant="tonal" color="blue">
                                نوعیت:
                                {{
                                    product.product_type?.name ||
                                    product.productType?.name ||
                                    product.product_type_id ||
                                    "نامعلوم"
                                }}
                            </v-chip>
                        </div>
                    </v-card-text>

                    <v-card-actions class="px-4 pb-4 pt-0">
                        <v-btn
                            color="primary"
                            variant="tonal"
                            rounded="xl"
                            block
                            prepend-icon="mdi-eye"
                            @click="goToDetails(product.id)"
                        >
                            دیدن جزئیات
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <div v-if="pageCount > 1" class="d-flex justify-center mt-6">
            <v-pagination
                v-model="currentPage"
                :length="pageCount"
                color="primary"
                rounded="circle"
            />
        </div>
        <v-dialog v-model="deleteDialog" max-width="420">
            <v-card rounded="xl">
                <v-card-title class="font-weight-bold">
                    حذف محصول
                </v-card-title>

                <v-card-text>
                    آیا مطمئن هستید که محصول
                    <strong>{{ selectedProduct?.name }}</strong>
                    حذف شود؟
                </v-card-text>

                <v-card-actions class="pa-4">
                    <v-spacer />

                    <v-btn
                        variant="tonal"
                        color="grey"
                        @click="deleteDialog = false"
                    >
                        لغو
                    </v-btn>

                    <v-btn
                        color="red"
                        :loading="deleteLoading"
                        @click="deleteProduct"
                    >
                        حذف کردن
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-snackbar
            v-model="snackbar.show"
            :color="snackbar.color"
            location="bottom"
        >
            {{ snackbar.text }}
        </v-snackbar>
    </v-container>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

const router = useRouter();
const WareHouseRepository = useWareHouseRepository();
// for pagenation
const currentPage = ref(1);
const itemsPerPage = 10;
const search = ref("");

const deleteDialog = ref(false);
const deleteLoading = ref(false);
const selectedProduct = ref(null);
watch(search, () => {
    currentPage.value = 1;
});

const snackbar = ref({
    show: false,
    color: "success",
    text: "",
});

const API_BASE_URL =
    import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000";

const getImageUrl = (path) => {
    if (!path) return "";

    if (path.startsWith("http")) {
        return path;
    }

    const cleanPath = path.startsWith("/") ? path.slice(1) : path;

    return `${API_BASE_URL}/storage/${cleanPath}`;
};
const showMessage = (text, color = "success") => {
    snackbar.value = {
        show: true,
        color,
        text,
    };
};

const formatMoney = (value) => {
    if (value === null || value === undefined || value === "") {
        return "۰";
    }

    return new Intl.NumberFormat("fa-AF").format(Number(value));
};

const daysUntilExpire = (date) => {
    if (!date) return null;

    const today = new Date();
    const expireDate = new Date(date);

    today.setHours(0, 0, 0, 0);
    expireDate.setHours(0, 0, 0, 0);

    return Math.ceil((expireDate - today) / (1000 * 60 * 60 * 24));
};

const isExpiringSoon = (date) => {
    const days = daysUntilExpire(date);

    return days !== null && days >= 0 && days <= 30;
};

const isExpired = (date) => {
    const days = daysUntilExpire(date);

    return days !== null && days < 0;
};

const expireClass = (date) => {
    if (isExpired(date)) return "text-red";
    if (isExpiringSoon(date)) return "text-orange";

    return "";
};

const productsList = computed(() => {
    if (Array.isArray(WareHouseRepository.products)) {
        return WareHouseRepository.products;
    }

    if (Array.isArray(WareHouseRepository.products?.data)) {
        return WareHouseRepository.products.data;
    }

    if (Array.isArray(WareHouseRepository.products?.items)) {
        return WareHouseRepository.products.items;
    }

    return [];
});

const filteredProducts = computed(() => {
    const q = (search.value || "").toLowerCase().trim();

    if (!q) {
        return productsList.value;
    }

    return productsList.value.filter((product) => {
        const warehouseName = product.warehouse?.name || "";
        const typeName =
            product.product_type?.name || product.productType?.name || "";

        return [
            product.name,
            product.product_company,
            product.note,
            warehouseName,
            typeName,
            product.main_price,
            product.sale_price,
        ]
            .join(" ")
            .toLowerCase()
            .includes(q);
    });
});
const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    return filteredProducts.value.slice(start, end);
});

const pageCount = computed(() => {
    return Math.ceil(filteredProducts.value.length / itemsPerPage);
});

const totalQuantity = computed(() => {
    return filteredProducts.value.reduce((total, product) => {
        return total + Number(product.product_quantity || 0);
    }, 0);
});

const expiringProductsCount = computed(() => {
    return filteredProducts.value.filter((product) =>
        isExpiringSoon(product.expire_date),
    ).length;
});

const goToDetails = (id) => {
    router.push({
        name: "products.details",
        params: { id },
    });
};

const openDeleteDialog = (product) => {
    selectedProduct.value = product;
    deleteDialog.value = true;
};

const deleteProduct = async () => {
    if (!selectedProduct.value?.id) return;

    deleteLoading.value = true;

    try {
        await WareHouseRepository.deleteproduct(selectedProduct.value.id);

        deleteDialog.value = false;
        selectedProduct.value = null;

        showMessage("محصول موفقانه حذف شد.", "success");

        await WareHouseRepository.fetchproducts({
            page: 1,
            itemsPerPage: 1000,
        });
    } catch (error) {
        showMessage("در حذف محصول مشکل رخ داد.", "error");
    } finally {
        deleteLoading.value = false;
    }
};

onMounted(async () => {
    await WareHouseRepository.fetchproducts({
        page: 1,
        itemsPerPage: 1000,
    });
});
</script>

<style scoped>
.products-page {
    min-height: 100%;
    padding: 28px;
    background:
        radial-gradient(
            circle at top right,
            rgba(103, 58, 183, 0.12),
            transparent 30%
        ),
        linear-gradient(180deg, #fafafa, #f5f7fb);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.search-card {
    border: 1px solid rgba(120, 120, 120, 0.14);
    background: rgba(255, 255, 255, 0.88);
}

.stats-row {
    display: flex;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 10px;
}

.loading-box {
    min-height: 320px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.empty-card {
    min-height: 320px;
    border: 1px dashed rgba(120, 120, 120, 0.35);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.product-card {
    height: 100%;
    overflow: hidden;
    border: 1px solid rgba(120, 120, 120, 0.14);
    background: rgba(255, 255, 255, 0.96);
    transition: 0.2s ease;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 34px rgba(20, 20, 20, 0.08);
}

.image-area {
    height: 220px;
    position: relative;
    background: #f3f4f8;
}

.no-image,
.image-error {
    height: 220px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: center;
    justify-content: center;
    color: #9e9e9e;
}

.image-error {
    color: #d32f2f;
}

.quantity-chip {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 3;
}

.product-title {
    font-size: 17px;
    font-weight: 800;
    line-height: 1.5;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
}

.info-box {
    background: #f7f7fb;
    border: 1px solid rgba(120, 120, 120, 0.1);
    border-radius: 16px;
    padding: 10px;
}

.info-box span {
    display: block;
    font-size: 12px;
    color: #757575;
    margin-bottom: 4px;
}

.info-box strong {
    font-size: 14px;
}

.relation-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.text-red {
    color: #d32f2f !important;
}

.text-orange {
    color: #ef6c00 !important;
}

@media (max-width: 600px) {
    .products-page {
        padding: 16px;
    }

    .stats-row {
        justify-content: flex-start;
    }
}
</style>
