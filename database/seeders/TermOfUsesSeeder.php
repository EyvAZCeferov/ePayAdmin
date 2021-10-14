<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermOfUsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'az_title' => 'Şərtlər və qaydalar',
            'ru_title' => 'Terms & Conditions',
            'en_title' => 'Условия и положения',
        ];
        $descriptors = [
            'az_description' => '
            Bir çox ağrı, sevginin özüdür, əsas saxlama sistemi. Ətrafdan tamamlanan banan çox yas və ya təbii ki, saf vəziyyətdə olmalıdır. Alkoqoldan başqa hər kəs. Bunun üçün pul ödəmək gözəl bir işdir. Güclü dayandırmaq. Rhoncus eleifend -in bütün növləri. Tam sayı mattis eleifend. Oklardan, isti bir çömçə ehtiyacı. Ayılar başlayana qədər və ya uşaqlar istiləşmədən əvvəl. Bunu etmək üçün heç bir yol yoxdur. Yarın tağların tağlarını bəzəmək vaxtıdır. Müqaviləyə uyğun olaraq, hər bir sinif üçün uyğundur. Hətta bəzi titrəyən pişiklər hamilə deyil. Hamı tur paketindədir. Ancaq indi vadi öz çeşidini əldən vermir. Curabitur arrow mauris və yalnız içməmək kədərlidir. Ancaq pişik çox yaxşıdır.

            Bəlkə də sousun heç bir problemə ehtiyacı yoxdur. Kənar vadisi kimdir Ağrı və işgəncəni cəzalandırmaq lazımdır. Mükəmməl bir tərz. Müqaviləyə uyğun olaraq, hər bir sinif üçün uyğundur. Yatağın yayında yaşayırıq, amma kədər sevgidir, göl zəhərlidir. Ən həyəcanlı yay və boğaz olduğu üçün vadinin ehtiyacı sıralanır. Maecenas oturmaq üçün bir az vaxt lazımdır. Bəziləri bərədən başqa heç nə demədilər. Ən həyəcanlı vaxt üçün indi titrəmə diapazonu gəlir. Amma gözəl bir yay deyil. Hamilə bir aktiv əsasında hesabları ödəmək artıq mümkündür.',
            'en_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ex dui, aliquet sit amet luctus vel, cursus in purus. Quisque sed egestas arcu. Donec eu laoreet eros. Suspendisse potenti. Integer ut turpis a dui rhoncus eleifend. Integer commodo mattis eleifend. Integer a sagittis velit, eget fermentum urna. Donec ullamcorper efficitur mauris, vel pellentesque ante fermentum id. Phasellus vestibulum justo nulla, ut sollicitudin justo viverra ut. Cras tempus arcu ornare orci vestibulum pharetra. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam aliquam pharetra felis non gravida. Quisque in pretium tellus. Sed feugiat nec nunc convallis rhoncus. Curabitur feugiat sagittis mauris, ac tristique justo bibendum non. Proin sed felis dui.

            Suspendisse condimentum eget neque a sollicitudin. Suspendisse quis convallis urna. Morbi ultricies ac tortor eget molestie. Pellentesque euismod sapien id tincidunt tristique. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus arcu lectus, malesuada sed sollicitudin sit amet, venenatis id lacus. Ut blandit arcu ac erat faucibus, eget convallis est fringilla. Maecenas sit amet quam at magna malesuada tincidunt. Vestibulum dictum aliquam nulla sed porttitor. Nam blandit rhoncus nunc pharetra sollicitudin. Sed non tincidunt arcu. Praesent laoreet nunc in ex gravida dignissim.',

            'ru_description' => 'Много боли - это сама любовь, основная система хранения. В комплекте с антуражем бананов должно быть много траура или, конечно, в чистом виде. Все, кроме алкоголя. Хорошая работа - за это платить. Suspendisse Potenti. Целое число ut turpis a dui rhoncus eleifend. Целочисленный коммодо маттис элеифенд. Чтобы выбрать по стрелкам, нужна теплая урна. Пока не начнут заводить медведей, или пока дети не начнут разминку. Это невозможно сделать. Завтра самое время украсить арку сводами колчана. Класс aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos Даже некоторые кошки-колчаны не беременны. Все в турпакете. Но сейчас долина не упускает своего диапазона. Curabitur feugiat arrow mauris, и грустно просто пить не надо. Но кот такой хороший.

            Может, с соусом не нужно беспокоиться. Кто такая долина урны Боль и мучитель должны быть наказаны. Pellentesque euismod sapien id tincidunt tristique. Класс aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos Мы живем в изголовье кровати, но печаль - это любовь, это озеро ядовито. Поскольку самый возбуждающий лук, и это было горло, нуждались в долине. Меценат сидят на берегу реки Магна Малесуада. Некоторые не сказали ничего, кроме парома. Для самого захватывающего времени сейчас ряд трепетал. Но не красивый поклон. Теперь можно оплачивать счета на основе беременного актива.',
        ];
        DB::table('term_of_uses')->insert([
            'titles' => json_encode($titles),
            'descriptors' => json_encode($descriptors),
        ]);
    }
}
