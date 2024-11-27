<template>
  <div class="exchange-component">
    <form>
      <div class="input-group">
        <label for="amount">You give:</label>
        <input
          type="number"
          id="amount"
          v-model="amount"
          placeholder="Enter amount"
        />
        <select v-model="currencyFrom">
          <option v-for="currency in currenciesYouGive" :key="currency" :value="currency">
            {{ currency.ticker }}
          </option>
        </select>
      </div>
      <div class="input-group">
        <label for="currency-to">You receive:</label>
        <select v-model="currencyTo">
          <option v-for="currency in currenciesYouReceive" :key="currency" :value="currency">
            {{ currency.destination_name ?? currency.quote }}
          </option>
        </select>
      </div>
      <div class="input-group-error">
        {{errorMessage}}
      </div>
      <div class="input-group">
        <label for="currency-to">Converted value: {{ convertedValue }}</label>
      </div>
      <div class="exchange-button">
        <button type="submit" @click.prevent="performExchange">Exchange</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import {ref, onMounted, watch} from "vue";
import apiClient from "@/configs/axios.js";
const amount = ref(0);
const currencyFrom = ref("");
const currencyTo = ref("");
const currenciesYouGive = ref([])
const currenciesYouReceive = ref([])
const errorMessage = ref('')
const convertedValue = ref('')

onMounted( async () => {
  currenciesYouGive.value = (await apiClient.get('/currencies/you-give')).data?.currencies
})

watch(() => currencyFrom.value, async (newValue) => {
  currenciesYouReceive.value =
    (await apiClient.get(`/currencies/you-receive/${newValue.name}`))
      .data?.currencies

})
const performExchange = async () => {
  try {
    let response = await apiClient.post(`/currencies/convert`, {
      giveCurrency: currencyFrom.value,
      receiveCurrency:  currencyTo.value?.destination_name ?
        {type: 'sheepy', ...currencyTo.value}
        : {type: 'binance', ...currencyTo.value},
      amount: amount.value
    });

    convertedValue.value = response.data.final_amount
  }catch (e) {
    errorMessage.value = e.response.data.error
    setTimeout(() => {
      errorMessage.value = ''
    }, 3000)
  }
};
</script>

<style>
.exchange-component {
  background: #f9f9f9;
  padding: 20px;
  max-width: 400px;
  border: 1px solid #ddd;
  border-radius: 8px;
  margin: 0 auto;
}

.input-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
.input-group-error {
  font-size: 15px;
  color: red;
}

input,
select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.exchange-button {
  text-align: center;
  margin-top: 20px;
}

button {
  background-color: #007bff;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

.price-info {
  margin-top: 15px;
  font-size: 14px;
  color: #555;
}
</style>
