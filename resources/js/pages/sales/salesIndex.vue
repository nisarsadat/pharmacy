<template>
    <!-- Search & Create -->
    <v-layout class="pt-6">
        <v-row class="justify-space-between px-6">
            <!-- Search -->
            <v-col cols="12" sm="4" md="3">
                <v-text-field
                    v-model="WareHouseRepository.search"
                    label="جستجو"
                    prepend-inner-icon="mdi-magnify"
                    variant="outlined"
                    density="comfortable"
                    rounded="xl"
                    hide-details
                    class="search-field"
                />
            </v-col>

            <!-- Create Button -->
            <div class="d-flex align-center">
                <v-btn
                    color="primary"
                    size="large"
                    rounded="xl"
                    elevation="2"
                    @click="create"
                >
                    <v-icon start>mdi-plus</v-icon>
                    فروش جدید
                </v-btn>
            </div>
        </v-row>
    </v-layout>

    <!-- Sales -->
    <v-container fluid class="mt-3">
        <v-row>
            <v-col
                v-for="sale in WareHouseRepository.sales"
                :key="sale.id"
                cols="12"
                md="6"
                lg="4"
            >
                <v-card
                    class="sale-card pa-4"
                    elevation="0"
                >
                    <!-- Header -->
                    <div
                        class="d-flex justify-space-between align-center mb-4"
                    >
                        <div>
                            <h3 class="text-h6 font-weight-bold">
                                فروش #{{ sale.id }}
                            </h3>

                            <div class="text-caption text-grey-darken-1">
                                {{ sale.date }}
                            </div>
                        </div>

                        <!-- Menu -->
                        <v-menu>
                            <template #activator="{ props }">
                                <v-btn
                                    icon
                                    variant="text"
                                    v-bind="props"
                                >
                                    <v-icon>
                                        mdi-dots-vertical
                                    </v-icon>
                                </v-btn>
                            </template>

                            <v-list rounded="lg">
                                <v-list-item
                                    @click="
                                        $router.push({
                                            name: 'sales.edit',
                                            params: { id: sale.id },
                                        })
                                    "
                                >
                                    <template #prepend>
                                        <v-icon color="green">
                                            mdi-pencil-outline
                                        </v-icon>
                                    </template>

                                    <v-list-item-title>
                                        ویرایش
                                    </v-list-item-title>
                                </v-list-item>

                                <v-list-item
                                    @click="deleteItem(sale.id)"
                                >
                                    <template #prepend>
                                        <v-icon color="red">
                                            mdi-delete-outline
                                        </v-icon>
                                    </template>

                                    <v-list-item-title>
                                        حذف
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </div>

                    <!-- Customer -->
                    <div class="customer-box mb-4">
                        <div class="d-flex align-center gap-4">
                            <v-avatar
                                size="58"
                                class="customer-avatar"
                            >
                                <v-img
                                    :src="`http://127.0.0.1:8000/storage/${sale.customer?.image}`"
                                    cover
                                />
                            </v-avatar>

                            <div>
                                <div class="font-weight-bold text-body-1">
                                    {{ sale.customer?.name }}
                                    {{ sale.customer?.last_name }}
                                </div>

                                <div
                                    class="text-caption text-grey-darken-1"
                                >
                                    {{ sale.customer?.phone_number }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="details-section">
                        <div class="detail-item">
                            <span>حساب</span>
                            <strong>
                                {{ sale.account?.name }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>گدام</span>
                            <strong>
                                {{ sale.warehouse?.name }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>مجموع</span>
                            <strong>
                                {{ sale.total_amount }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>تخفیف</span>
                            <strong>
                                {{ sale.discount }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>مقدار نهایی</span>
                            <strong class="text-primary">
                                {{ sale.final_amount }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>پرداخت</span>
                            <strong>
                                {{ sale.paid_amount }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>قرض</span>
                            <strong class="text-red">
                                {{ sale.due_amount }}
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>نوت</span>
                            <strong>
                                {{ sale.note || "ندارد" }}
                            </strong>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="mt-5">
                        <div
                            class="d-flex justify-space-between align-center mb-3"
                        >
                            <h4 class="text-subtitle-1 font-weight-bold">
                                محصولات
                            </h4>

                            <v-chip
                                size="small"
                                color="primary"
                                variant="tonal"
                            >
                                {{ sale.items.length }} محصول
                            </v-chip>
                        </div>

                        <v-row dense>
                            <v-col
                                cols="12"
                                v-for="item in sale.items"
                                :key="item.id"
                            >
                                <v-card
                                    class="product-card px-3 py-2"
                                    elevation="0"
                                >
                                    <div
                                        class="d-flex align-center justify-space-between"
                                    >
                                        <!-- Left -->
                                        <div
                                            class="d-flex align-center gap-3"
                                        >
                                            <!-- Image -->
                                            <v-avatar
                                                rounded="lg"
                                                size="50"
                                                class="product-avatar"
                                            >
                                                <v-img
                                                    src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png"
                                                    cover
                                                />
                                            </v-avatar>

                                            <!-- Product Details -->
                                            <div>
                                                <div
                                                    class="font-weight-medium text-body-2"
                                                >
                                                    {{
                                                        item.product?.name
                                                    }}
                                                </div>

                                                <div
                                                    class="d-flex gap-3 text-caption text-grey-darken-1 mt-1"
                                                >
                                                    <span>
                                                        Qty:
                                                        {{
                                                            item.quantity
                                                        }}
                                                    </span>

                                                    <span>
                                                        Price:
                                                        {{ item.price }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Total -->
                                        <div class="text-right">
                                            <div
                                                class="font-weight-bold text-primary"
                                            >
                                                {{ item.total }}
                                            </div>
                                        </div>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </div>
                </v-card>
            </v-col>
        </v-row>

        <!-- Pagination -->
        <div class="d-flex justify-center mt-8">
            <v-pagination
                v-model="WareHouseRepository.page"
                :length="
                    Math.ceil(
                        WareHouseRepository.totalItems /
                            WareHouseRepository.itemsPerPage
                    )
                "
                rounded="circle"
                @update:modelValue="
                    fetchsales({
                        page: WareHouseRepository.page,
                        itemsPerPage:
                            WareHouseRepository.itemsPerPage,
                    })
                "
            />
        </div>
    </v-container>
</template>

<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

const WareHouseRepository = useWareHouseRepository();

const router = useRouter();

const create = () => {
    router.push("./sales/create");
};

const deleteItem = (id) => {
    WareHouseRepository.deletesale(id);
};

const fetchsales = ({ page, itemsPerPage }) => {
    WareHouseRepository.fetchsales({
        page,
        itemsPerPage,
    });
};

onMounted(() => {
    fetchsales({
        page: 1,
        itemsPerPage: 5,
    });
});
</script>

<style scoped>
.sale-card {
    border-radius: 24px;
    background: linear-gradient(
        145deg,
        #ffffff,
        #f8fafc
    );

    border: 1px solid #edf2f7;

    transition: all 0.3s ease;
}

.sale-card:hover {
    transform: translateY(-5px);

    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.08);
}

.search-field {
    backdrop-filter: blur(10px);
}

.customer-box {
    background: linear-gradient(
        135deg,
        #f8fafc,
        #f1f5f9
    );

    border-radius: 18px;

    padding: 14px;

    border: 1px solid #edf2f7;
}

.customer-avatar {
    border: 3px solid white;

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

.details-section {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.detail-item {
    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 12px 14px;

    border-radius: 14px;

    background: #f8fafc;

    border: 1px solid #edf2f7;

    transition: 0.2s;
}

.detail-item:hover {
    background: #f1f5f9;
}

.product-card {
    border-radius: 16px;

    background: linear-gradient(
        135deg,
        #ffffff,
        #f8fafc
    );

    border: 1px solid #edf2f7;

    transition: all 0.25s ease;
}

.product-card:hover {
    transform: translateY(-2px);

    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
}

.product-avatar {
    border: 2px solid #e0e7ff;
}

.text-red {
    color: #ef4444;
}
</style>