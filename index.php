<?php
require_once './vendor/autoload.php';
?>


<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link rel="stylesheet" href="">
<style>
</style>
<script src=""></script>
<body>

<div class="">
    <div class="container">
        <div id="app">
            <h1>Расчет стоимости доставки</h1>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Параметры доставки</h4>
                <b-form @submit.prevent="onSubmit" @reset="onReset" class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">Адрес отправления</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required="" v-model="source">
                            <div class="invalid-feedback">
                                Адрес необходим
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Адрес доставки</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required="" v-model="target">
                            <div class="invalid-feedback">
                                Адрес необходим
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Вес отправления, кг</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required="" v-model="weight">
                            <div class="invalid-feedback">
                                Требуется указать вес отправления
                            </div>
                        </div>
                    </div>

                    <b-alert :show="invalidForm" variant="warning">
                        Проверьте правильность введённых данных
                    </b-alert>

                    <b-spinner v-if="progress" variant="primary" type="grow" label="Spinning"></b-spinner>

                    <b-button v-else type="submit" variant="primary">Рассчитать</b-button>

                    <b-table striped hover :items="costs" class="mt-4"></b-table>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-vue/2.22.0/bootstrap-vue.min.js" integrity="sha512-fpl6VxrVL83pzi0dMBPknsykT+mf3+TLzBigOtNKp1cPi2oEpooeOzTb+tOku1YhL7/0eDfe9nnzCPzuAwvtog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js" integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const apiUrl = '/api.php';

    const App = new Vue({
        el: '#app',

        data: () => ({
            weight: 0,
            source: '',
            target: '',

            costs: {},
            invalidForm: false,

            progress: false,
        }),

        methods: {
            validate() {
                this.invalidForm = false;

                if (!(this.weight && this.source && this.target)) {
                    this.invalidForm = true;

                    return false;
                }

                return true;
            },

            async onSubmit() {
                this.costs = {};

                try {
                    if (!this.validate()) {
                        return;
                    }

                    const { data } = await axios.get(apiUrl, {
                        params: {
                            weight: this.weight,
                            source: this.source,
                            target: this.target,
                        }
                    });

                    this.costs = data;
                } catch (e) {
                    console.error(e);
                } finally {
                    this.progress = false;
                }
            },

            onReset() {

            },

            onInputUpdate() {
                console.log('updated');
            }
        }
    })
</script>

</body>
</html>
