<h1 class="page-header"><?=\yii::t('page/agreement', 'Agreement')?></h1>

<p>
    <?=\yii::t('page/agreement', '{app} is developed by {dataart} and distributed under Open Source {mit}MIT license{/mit}.', array(
        '{app}'     => '<strong>' . \yii::app()->name . '</strong>',
        '{dataart}' => '<a href="http://dataart.com/" target="_blank">DataArt Apps</a>',
        '{mit}'     => '<a href="http://en.wikipedia.org/wiki/MIT_License" target="_blank">',
        '{/mit}'    => '</a>',
    ))?>
    <?=\yii::t('page/agreement', 'This basically means you can do whatever you want with the software as long as the copyright notice is included.')?>
    <?=\yii::t('page/agreement', 'This also menas you don\'t have to contribute the end product or modified sources back to Open Source, but if you feel like sharing, you are highly encouraged to do so!')?>
</p>

<p>
    <?=\yii::t('page/agreement', 'Copyright &copy; {year} DataArt Apps', array(
        '{year}' => date('Y'),
    ))?>
</p>

<p>
    <?=\yii::t('app', '{app} не является средством массовой информации, Администрация ресурса не обязана осуществлять редактирование размещаемой информации, ее предварительную модерацию и не несёт ответственность за её содержание.', array(
        '{app}' => '<strong>' . \yii::app()->name . '</strong>',
    ))?>
</p>

<p>
    <?=\yii::t('app', 'На {app} уважается и защищается авторское право и связанные с ним личные имущественные и неимущественные права. Использование произведений без согласия автора допускается лишь в установленных законом случаях.', array(
        '{app}' => '<strong>' . \yii::app()->name . '</strong>',
    ))?>
</p>

<p>
    <?=\yii::t('app', 'Лицо, разместившее информацию на {app}, самостоятельно представляет и защищает свои интересы, возникающие в связи с размещением указанной информации, в отношениях с третьими лицами.', array(
        '{app}' => '<strong>' . \yii::app()->name . '</strong>',
    ))?>
</p>

<p>
    <?=\yii::t('app', 'The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.')?>
</p>

<p>
    <?=\yii::t('app', 'THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. ')?>
    <?=\yii::t('app', 'IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.')?>
</p>