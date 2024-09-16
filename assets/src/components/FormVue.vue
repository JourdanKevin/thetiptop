<template>
    <form @submit.prevent="handleSubmit">
      <template v-for="(field, key) in formFields" :key="key">
        <div>
          <input :type="field.type" :id="key" :name="key" placeholder="" v-model="datas[key]" :required="field.required" :pattern="field.pattern" :title="field.title">
          <label :for="key">{{ field.label }}</label>
          <span v-if="field.error" style="color: red;">{{ field.error }}</span>
        </div>
        <div v-if="field.confirm">
          <input :type="field.type" :id="key+'_confirm'" :name="key+'_confirm'" placeholder="" :required="field.required" :pattern="field.pattern" @blur="checkConfirmation(key)">
          <label :for="key+'_confirm'">{{ field.confirm }}</label>
          <span v-if="confirmationsError.includes(key+'_confirm')" style="color: red;">Les valeurs des {{ field.label }} ne correspondent pas.</span>
        </div>
      </template>
      <button type="submit" :disabled="confirmationsError.length > 0">{{ submitText }}</button>
    </form>
  </template>
  
  <script>
  export default {
    props: ['datas', 'formFields','submitText'],
    data(){
      return {
        confirmationsError : []
      }
    },
    methods:{
      checkConfirmation(inputKey) {
        const inputValue = this.datas[inputKey];
        const confirmationInputId = inputKey + '_confirm';
        const confirmationInput = document.getElementById(confirmationInputId);
        const confirmationValue = confirmationInput.value;
        
        if (inputValue !== confirmationValue) {
          this.confirmationsError.push(confirmationInputId);
        } else {
          const index = this.confirmationsError.indexOf(confirmationInputId);
          if (index !== -1) {
            this.confirmationsError.splice(index, 1);
          }
        }
      }
    }
  };
  </script>