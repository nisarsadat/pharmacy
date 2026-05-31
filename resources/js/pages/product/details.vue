
<template>
    <v-container fluid class="details-page" dir="rtl">
        <!-- Loading -->
        <div v-if="loading" class="loading-box">
            <v-progress-circular indeterminate color="primary" size="48" />
            <div class="mt-3 text-body-2 text-medium-emphasis">
                جزئیات محصول در حال بارگذاری است...
            </div>
        </div>

        <!-- Not Found -->
        <v-card
            v-else-if="!product"
            class="empty-card"
            elevation="0"
            rounded="xl"
        >
            <v-icon size="64" color="grey">mdi-alert-circle-outline</v-icon>
            <h3 class="mt-3 mb-1">محصول پیدا نشد</h3>
            <p class="text-body-2 text-medium-emphasis">
                ممکن است این محصول حذف شده باشد یا شناسه آن درست نباشد.
            </p>

            <v-btn
                color="primary"
                rounded="xl"
                class="mt-4"
                prepend-icon="mdi-arrow-right"
                @click="$router.push('/products')"
            >
                برگشت به محصولات
            </v-btn>
        </v-card>

        <!-- Details -->
        <template v-else>
            <div class="page-header">
                <div>
                    <h1 class="text-h5 font-weight-bold mb-1">
                        جزئیات محصول
                    </h1>
                    <p class="text-body-2 text-medium-emphasis mb-0">
                        معلومات کامل محصول، قیمت‌ها، تاریخ‌ها و تصاویر.
                    </p>
                </div>

                <div class="header-actions">
                    <v-btn
                        color="grey-darken-1"
                        variant="tonal"
                        rounded="xl"
                        prepend-icon="mdi-arrow-right"
                        @click="$router.push('/products')"
                    >
                        برگشت
                    </v-btn>

                    <v-btn
                        color="primary"
                        rounded="xl"
                        prepend-icon="mdi-square-edit-outline"
                        @click="
                            $router.push({
                                name: 'products.edit',
                                params: { id: product.id },
                            })
                        "
                    >
                        ویرایش
                    </v-btn>
                </div>
            </div>

            <v-row dense>
                <!-- Images -->
                <v-col cols="12" lg="5">
                    <v-card class="main-card" elevation="0" rounded="xl">
                        <v-carousel
                            v-if="product.images && product.images.length"
                            height="430"
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
        height="430"
        cover
    />
</v-carousel-item>
                        </v-carousel>

                        <div v-else class="no-image-large">
                            <v-icon size="80" color="grey-lighten-1">
                                mdi-image-off-outline
                            </v-icon>
                            <div class="mt-2">عکس برای این محصول ثبت نشده است</div>
                        </div>
                    </v-card>
                </v-col>

                <!-- Main Info -->
                <v-col cols="12" lg="7">
                    <v-card class="main-card pa-5" elevation="0" rounded="xl">
                        <div class="product-top">
                            <div>
                                <h2 class="text-h5 font-weight-bold mb-1">
                                    {{ product.name || "بدون اسم" }}
                                </h2>

                                <p class="text-body-2 text-medium-emphasis mb-0">
                                    {{ product.product_company || "شرکت / کارخانه ثبت نشده" }}
                                </p>
                            </div>

                            <v-chip
                                :color="Number(product.product_quantity) > 0 ? 'green' : 'red'"
                                variant="tonal"
                                size="large"
                            >
                                {{ Number(product.product_quantity || 0) > 0 ? "موجود است" : "تمام شده" }}
                            </v-chip>
                        </div>

                        <v-divider class="my-5" />

                        <v-row dense>
                            <v-col cols="12" sm="6">
                                <InfoBox
                                    icon="mdi-cash"
                                    label="قیمت اصلی"
                                    :value="formatMoney(product.main_price)"
                                />
                            </v-col>

                            <v-col cols="12" sm="6">
                                <InfoBox
                                    icon="mdi-sale"
                                    label="قیمت فروش"
                                    :value="formatMoney(product.sale_price)"
                                />
                            </v-col>

                            <v-col cols="12" sm="6">
                                <InfoBox
                                    icon="mdi-counter"
                                    label="مقدار محصول"
                                    :value="product.product_quantity || '۰'"
                                />
                            </v-col>

                            <v-col cols="12" sm="6">
                                <InfoBox
                                    icon="mdi-factory"
                                    label="شرکت / کارخانه"
                                    :value="product.product_company || 'ثبت نشده'"
                                />
                            </v-col>

                            <v-col cols="12" sm="6">
                                <InfoBox
                                    icon="mdi-warehouse"
                                    label="گدام"
                                    :value="product.warehouse?.name || product.warehouse_id || 'نامعلوم'"
                                />
                            </v-col>

                            <v-col cols="12" sm="6">
                                <InfoBox
                                    icon="mdi-shape"
                                    label="نوعیت محصول"
                                    :value="product.product_type?.name || product.productType?.name || product.product_type_id || 'نامعلوم'"
                                />
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>

                <!-- Dates -->
                <v-col cols="12" lg="6">
                    <v-card class="main-card pa-5" elevation="0" rounded="xl">
                        <SectionTitle icon="mdi-calendar" title="تاریخ‌ها" />

                        <div class="date-list">
                            <div class="date-row">
                                <span>تاریخ ثبت</span>
                                <strong>{{ product.date || "ثبت نشده" }}</strong>
                            </div>

                            <div class="date-row">
                                <span>تاریخ تولید</span>
                                <strong>{{ product.produced_date || product.product_date || "ثبت نشده" }}</strong>
                            </div>

                            <div class="date-row">
                                <span>تاریخ انقضا</span>
                                <strong :class="expireClass(product.expire_date)">
                                    {{ product.expire_date || "ثبت نشده" }}
                                </strong>
                            </div>

                            <v-alert
                                v-if="expireMessage"
                                :type="expireAlertType"
                                variant="tonal"
                                density="compact"
                                class="mt-4"
                            >
                                {{ expireMessage }}
                            </v-alert>
                        </div>
                    </v-card>
                </v-col>

                <!-- Note -->
                <v-col cols="12" lg="6">
                    <v-card class="main-card pa-5" elevation="0" rounded="xl">
                        <SectionTitle icon="mdi-note-text-outline" title="نوت" />

                        <div class="note-box">
                            {{ product.note || "برای این محصول نوت ثبت نشده است." }}
                        </div>
                    </v-card>
                </v-col>

               
            </v-row>
        </template>
    </v-container>
</template>

<script setup>
import { computed, defineComponent, h, onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

const route = useRoute();
const WareHouseRepository = useWareHouseRepository();

const loading = ref(false);
const product = ref(null);

const getImageUrl = (path) => {
    if (!path) return "";

    if (path.startsWith("http")) {
        return path;
    }

    const cleanPath = path.startsWith("/") ? path.slice(1) : path;

    return `/storage/${cleanPath}`;
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

const isExpired = (date) => {
    const days = daysUntilExpire(date);

    return days !== null && days < 0;
};

const isExpiringSoon = (date) => {
    const days = daysUntilExpire(date);

    return days !== null && days >= 0 && days <= 30;
};

const expireClass = (date) => {
    if (isExpired(date)) return "text-red";
    if (isExpiringSoon(date)) return "text-orange";

    return "text-green";
};

const expireMessage = computed(() => {
    const days = daysUntilExpire(product.value?.expire_date);

    if (days === null) {
        return "";
    }

    if (days < 0) {
        return "تاریخ انقضای این محصول گذشته است.";
    }

    if (days === 0) {
        return "تاریخ انقضای این محصول امروز است.";
    }

    if (days <= 30) {
        return `این محصول تا ${days} روز دیگر منقضی می‌شود.`;
    }

    return "تاریخ انقضای این محصول فعلاً قابل قبول است.";
});

const expireAlertType = computed(() => {
    if (isExpired(product.value?.expire_date)) {
        return "error";
    }

    if (isExpiringSoon(product.value?.expire_date)) {
        return "warning";
    }

    return "success";
});

const loadProduct = async () => {
    loading.value = true;

    try {
        const id = route.params.id;

        product.value = await WareHouseRepository.fetchproduct(id);
    } catch (error) {
        product.value = null;
        console.error("Failed to load product:", error);
    } finally {
        loading.value = false;
    }
};

const InfoBox = defineComponent({
    props: {
        icon: String,
        label: String,
        value: [String, Number],
    },
    setup(props) {
        return () =>
            h("div", { class: "info-box" }, [
                h("div", { class: "info-icon" }, [
                    h("i", { class: `mdi ${props.icon}` }),
                ]),
                h("div", [
                    h("span", props.label),
                    h("strong", props.value),
                ]),
            ]);
    },
});

const SectionTitle = defineComponent({
    props: {
        icon: String,
        title: String,
    },
    setup(props) {
        return () =>
            h("div", { class: "section-title" }, [
                h("i", { class: `mdi ${props.icon}` }),
                h("span", props.title),
            ]);
    },
});

onMounted(() => {
    loadProduct();
});
</script>

<style scoped>
.details-page {
    min-height: 100%;
    padding: 28px;
    background:
        radial-gradient(circle at top right, rgba(103, 58, 183, 0.12), transparent 30%),
        linear-gradient(180deg, #fafafa, #f5f7fb);
}

.loading-box,
.empty-card {
    min-height: 420px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.empty-card {
    border: 1px dashed rgba(120, 120, 120, 0.35);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.main-card {
    border: 1px solid rgba(120, 120, 120, 0.14);
    background: rgba(255, 255, 255, 0.96);
    overflow: hidden;
    height: 100%;
}

.no-image-large {
    height: 430px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9e9e9e;
    background: #f3f4f8;
}

.product-top {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    align-items: flex-start;
    flex-wrap: wrap;
}

.info-box {
    min-height: 86px;
    background: #f7f7fb;
    border: 1px solid rgba(120, 120, 120, 0.1);
    border-radius: 18px;
    padding: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.info-icon {
    width: 42px;
    height: 42px;
    border-radius: 14px;
    background: #ede7f6;
    color: #5e35b1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.info-box span {
    display: block;
    font-size: 12px;
    color: #757575;
    margin-bottom: 5px;
}

.info-box strong {
    font-size: 15px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 800;
    color: #4527a0;
    margin-bottom: 16px;
    font-size: 16px;
}

.section-title i {
    font-size: 22px;
}

.date-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
</style>
