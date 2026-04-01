
<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="MoneyAccountRepository.updateDailog"
        width="800px"
        class="form-wrapper"

    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3 w-full">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>UPDATE</h2>
                    <v-btn variant="text" @click="isActive.value = false" color="red">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <v-text-field
                            v-model="formData.name"
                            variant="outlined"
                            density="compact"
                            label="Bank*"
                            :rules="[rules.required]"
                            class="pb-4"
                            fullWidth
                        ></v-text-field>

                        <div class="d-flex align-center pb-4 gap-4">
                            <v-autocomplete
                                v-model="formData.currencyId"
                                @update:modelValue="
                                    MoneyAccountRepository.GetCurrency(
                                        MoneyAccountRepository.currency
                                            .currencies,
                                        formData.currencyId
                                    )
                                "
                                :items="
                                    MoneyAccountRepository.currency.currencies
                                "
                                label="Currency*"
                                :rules="[rules.required]"
                                :return-object="false"
                                variant="outlined"
                                density="compact"
                                item-title="symbol"
                                item-value="id"
                            ></v-autocomplete>
                            <v-text-field
                                v-model="formData.price"
                                variant="outlined"
                                density="compact"
                                label="Price*"
                                :rules="[rules.required, rules.counter]"
                                class="relative"
                            >
                                <span
                                    class="absolute inset-y-0 right-0 flex items-center w-14 h-full pr-3 bg-gray-400 rounded-sm p-2 cursor-pointer"
                                >
                                    {{ MoneyAccountRepository.symbol }}
                                </span>
                            </v-text-field>
                        </div>
                        <v-textarea
                        v-model="formData.detials"
                        variant="outlined"
                        density="compact"
                        label="Detials"
                        :rules="[rules.required]"
                        class="pb-4"
                        fullWidth
                    ></v-textarea>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="updateaccount"
                        >Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
<script setup>
import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";
import { reactive, ref } from "vue";
let MoneyAccountRepository = useMoneyAccountRepository();
MoneyAccountRepository.GetAccounts();
const formRef = ref(null);
const formData = reactive({
    id: MoneyAccountRepository.account.id,
    name: MoneyAccountRepository.account.name,
    price: MoneyAccountRepository.account.price,
    symbol: MoneyAccountRepository.currency.symbol,
    currencyId: MoneyAccountRepository.account.currency?.symbol,
    detials:MoneyAccountRepository.account.detials,
});
// this the validtaion rules
const rules = {
    required: (value) => !!value || " Required.",
    counter: (value) => value.length >= 1 || "Min 1 characters",
};
// functions to create 

const updateaccount = async () => {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            MoneyAccountRepository.UpdateAccount(formData.id, formData);
        }
    });
};
</script>