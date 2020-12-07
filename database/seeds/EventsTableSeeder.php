<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Event;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('events')->delete();
        Event::create([
          'title_fr' => 'Petit âge glaciaire',
          'start_year' => 1400,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1850,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Augmentation des précipitations, des débits, et du transport sédimentaire',
          'bibliography_fr' => 'G. Pichard, E. Roucaute, 2014. Sept siècles d’histoire hydroclimatique du Rhône d’Orange à la mer (1300‑2000), climat, crues, inondations. Revue Méditerranée, no hors‑série, 192 p.',
          'km_up' => null,
          'km_down' => null,
          'theme_id' => 5,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Traité des limites',
          'start_year' => 1760,
          'start_month' => 3,
          'start_day' => 24,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Traité conclu entre le Roi de France et le Roi de Sardaigne. Il impose deux "lignes latérales" qui doivent servir à "déterminer l’alignement des ouvrages défensifs qu’on pourra opposer de part et d’autre au débordement du fleuve"',
          'bibliography_fr' => 'Cabinet de Castelnau, Bravard J.P., 2013. Etude historique et juridique sur les digues orphelines du Haut-Rhône. Etude pour le compte du SHR, 166 p.',
          'km_up' => 12.76,
          'km_down' => 12.84,
          'theme_id' => 2,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((6.040201 46.22603, 6.006035 45.598742, 5.54639 45.61009, 5.575225 46.230417, 5.577276 46.237522, 6.040201 46.22603)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Construction de digues dans le Haut-Rhône',
          'start_year' => 1760,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1890,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Les digues suivent la ligne latérale de rive gauche',
          'bibliography_fr' => null,
          'km_up' => 0,
          'km_down' => 155.5,
          'theme_id' => 7,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((6.16718 46.255414, 6.128307 45.575143, 5.338184 45.594354, 5.367278 46.27546, 6.16718 46.255414)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Création du service spécial du Rhône',
          'start_year' => 1840,
          'start_month' => null,
          'start_day' => null,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Les digues suivent la ligne latérale de rive gauche',
          'bibliography_fr' => null,
          'km_up' => null,
          'km_down' => null,
          'theme_id' => 6,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Crue généralisée 1840',
          'start_year' => 1840,
          'start_month' => null,
          'start_day' => null,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => '9000 m3/s à Beaucaire',
          'bibliography_fr' => 'Etude Globale Rhône, 2000; Bravard J.P., Clémens A., 2008. Le Rhône en 100 questions. Chapitre 5 : Les crues et inondations du Rhône. Zone Atelier Bassin du Rhône, 41 p.',
          'km_up' => 485,
          'km_down' => 486,
          'theme_id' => 5,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'points' => DB::raw("ST_GeomFromText('MULTIPOINT(4.651154 43.804714)')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Première phase resserrement du lit mineur en aval de Lyon',
          'start_year' => 1840,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1876,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Construction de digues insubmersibles',
          'bibliography_fr' => null,
          'km_up' => 214.3,
          'km_down' => 549.3,
          'theme_id' => 8,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((4.123159 45.738898,5.087203 45.718022,5.086978 45.712067,4.999368 43.289544,4.078998 43.30265,4.123159 45.738898)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Augmentation des forêts de bois tendre',
          'start_year' => 1850,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1950,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => null,
          'bibliography_fr' => 'B. Pont, RNN Ile de la Platière',
          'km_up' => null,
          'km_down' => null,
          'theme_id' => 3,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Crue généralisée 1856',
          'start_year' => 1856,
          'start_month' => 5,
          'start_day' => 31,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => '12000 m3/s à Beaucaire. Crue de "référence" en aval de Lyon : c’est sur cette base que sont élaborés les Plans de Prévention des Risques d’Inondation',
          'bibliography_fr' => 'Etude Globale Rhône, 2000; Bravard J.P., Clémens A., 2008. Le Rhône en 100 questions. Chapitre 5 : Les crues et inondations du Rhône. Zone Atelier Bassin du Rhône, 41 p.',
          'km_up' => 485,
          'km_down' => 486,
          'theme_id' => 5,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'points' => DB::raw("ST_GeomFromText('MULTIPOINT(4.651154 43.804714)')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Loi sur la capacité d\'ecrêtement des crues des plaines alluviales',
          'start_year' => 1858,
          'start_month' => 5,
          'start_day' => 28,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Cette loi déclare le territoire fluvial du Haut-Rhône comme Zone d\'Expansion des Crues',
          'bibliography_fr' => null,
          'km_up' => null,
          'km_down' => null,
          'theme_id' => 2,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Aménagement du canal Saint-Louis',
          'start_year' => 1863,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1871,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Canal de navigation qui relie le golfe de Fos au Grand Rhône (Port-Saint-Louis-du-Rhône)',
          'bibliography_fr' => null,
          'km_up' => 542,
          'km_down' => null,
          'theme_id' => 8,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((4.80178 43.38093,4.802037 43.395465,4.855676 43.393695,4.854437 43.379753,4.80178 43.38093)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Aménagement de l\'embouchure du Rhône avec digues, puis rupture',
          'start_year' => 1872,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1892,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Grande importance sur la morphologie de l\'embouchure : contrôle les zones de dépôt des sables en fonction des vagues',
          'bibliography_fr' => 'F. Sabatier, CEREGE',
          'km_up' => 507.4,
          'km_down' => 549.3,
          'theme_id' => 4,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((4.34683 43.633959,4.86689 43.626985,4.857271 43.329991,4.338928 43.337649,4.34683 43.633959)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Seconde phase de resserrement du lit mineur en aval de Lyon',
          'start_year' => 1876,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1884,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Construction d\'épis',
          'bibliography_fr' => null,
          'km_up' => 214.3,
          'km_down' => 549.3,
          'theme_id' => 8,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((4.123159 45.738898,5.087203 45.718022,5.086978 45.712067,4.999368 43.289544,4.078998 43.30265,4.123159 45.738898)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Lancement du plan Freycinet',
          'start_year' => 1878,
          'start_month' => 5,
          'start_day' => 18,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Programme national de travaux publics pour la construction de chemins de fer, de canaux et d\'installations portuaires',
          'bibliography_fr' => null,
          'km_up' => null,
          'km_down' => null,
          'theme_id' => 1,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Transformation d\'un style fluvial en tresses / anabranches à un chenal unique. Assèchement des bras secondaires',
          'start_year' => 1884,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1950,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Rhône en aval de Lyon',
          'bibliography_fr' => 'Thèse E. Parrot, 2015. Programme OSR',
          'km_up' => 214.9,
          'km_down' => 494,
          'theme_id' => 4,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((5.046194 45.71584,4.97508 43.725203,4.134806 43.741965,4.182382 45.728211,5.046194 45.71584)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Exhaussement des marges construites par piégeage des sédiments grossiers',
          'start_year' => 1884,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1950,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Rhône en aval de Lyon',
          'bibliography_fr' => 'Thèse E. Parrot, 2015, Thèse B. Räpple, 2018. Programme OSR',
          'km_up' => 214.9,
          'km_down' => 494,
          'theme_id' => 4,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((5.046194 45.71584,4.97508 43.725203,4.134806 43.741965,4.182382 45.728211,5.046194 45.71584)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Incision du fond du chenal',
          'start_year' => 1884,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1950,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Rhône en aval de Lyon',
          'bibliography_fr' => 'Thèse E. Parrot, 2015. Programme OSR',
          'km_up' => 214.9,
          'km_down' => 494,
          'theme_id' => 4,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((5.046194 45.71584,4.97508 43.725203,4.134806 43.741965,4.182382 45.728211,5.046194 45.71584)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Pavage progressif du lit',
          'start_year' => 1884,
          'start_month' => null,
          'start_day' => null,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Rhône en aval de Lyon',
          'bibliography_fr' => 'Thèse E. Parrot, 2015. Programme OSR',
          'km_up' => 214.9,
          'km_down' => 494,
          'theme_id' => 4,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((5.046194 45.71584,4.97508 43.725203,4.134806 43.741965,4.182382 45.728211,5.046194 45.71584)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Aménagements Girardon en aval de Lyon',
          'start_year' => 1884,
          'start_month' => null,
          'start_day' => null,
          'end_year' => 1938,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Construction de digues basses, traverses, tenons et épis',
          'bibliography_fr' => null,
          'km_up' => 214.3,
          'km_down' => 549.3,
          'theme_id' => 8,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'polygons' => DB::raw("ST_GeomFromText('MULTIPOLYGON(((4.123159 45.738898,5.087203 45.718022,5.086978 45.712067,4.999368 43.289544,4.078998 43.30265,4.123159 45.738898)))')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Loi sur l\'aménagement du Rhône',
          'start_year' => 1921,
          'start_month' => 5,
          'start_day' => 27,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => 'Loi approuvant le programme des travaux d’aménagement du Rhône, de la frontière suisse à la mer, au triple point de vue des forces motrices, de la navigation et des irrigations et autres utilisations agricoles, et créant les ressources financières correspondantes',
          'bibliography_fr' => null,
          'km_up' => null,
          'km_down' => null,
          'theme_id' => 2,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Création de la Compagnie nationale du Rhône',
          'start_year' => 1933,
          'start_month' => null,
          'start_day' => null,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => null,
          'bibliography_fr' => null,
          'km_up' => null,
          'km_down' => null,
          'theme_id' => 6,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Event::create([
          'title_fr' => 'Mise en service du barrage de Jons',
          'start_year' => 1937,
          'start_month' => null,
          'start_day' => null,
          'end_year' => null,
          'end_month' => null,
          'end_day' => null,
          'description_fr' => null,
          'bibliography_fr' => null,
          'km_up' => 186.1,
          'km_down' => null,
          'theme_id' => 9,
          'user_id' => 1,
          'creator' => 'Fanny Arnaud',
          'points' => DB::raw("ST_GeomFromText('MULTIPOINT(5.085102 45.812762)')"),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Model::reguard();
    }
}
