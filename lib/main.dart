import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_native_splash/flutter_native_splash.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:realm/realm.dart';
import 'package:serbizio_ph/firebase_options.dart';
import 'package:serbizio_ph/src/bindings/general_bindings.dart';
import 'package:serbizio_ph/src/features/authentication/pages/introduction_page.dart';
import 'package:serbizio_ph/src/data/repositories/authentication/authentication_repository.dart';
import 'package:serbizio_ph/src/features/home/realm/app_services.dart';
import 'package:serbizio_ph/src/features/home/realm/realm_services.dart';
import 'package:serbizio_ph/src/utils/theme/app_theme.dart';

Future<void> main() async {
  // Widget Binding
  final WidgetsBinding widgetsBinding = WidgetsFlutterBinding.ensureInitialized();
  Config realmConfig = await Config.getConfig('assets/config/atlasConfig.json');
  final appConfig = AppConfiguration(realmConfig.appId);
  final app = App(appConfig);
  if (app.currentUser == null) {
    try {
      final anonCredentials = Credentials.anonymous();
      await app.logIn(anonCredentials);
    } catch (e) {
      debugPrint(e.toString());
    }
  }

  // Await splash until other load
  FlutterNativeSplash.preserve(widgetsBinding: widgetsBinding);

  // Initialize Firebase & Authentication Repository
  await Firebase.initializeApp(options: DefaultFirebaseOptions.android).then(
    (FirebaseApp value) => Get.put(AuthenticationRepository())
  );

  // To make sure app always portrait up
  await SystemChrome.setPreferredOrientations(
    [DeviceOrientation.portraitUp]
  ).then((value) => runApp(
    MultiProvider(
      providers: [
        // ChangeNotifierProvider(create: (_) => GlobalValue()),
        ChangeNotifierProvider<Config>(create: (_) => realmConfig),
        ChangeNotifierProvider<AppServices>(
          create: (_) => AppServices(realmConfig.appId, realmConfig.baseUrl)
        ),
        ChangeNotifierProxyProvider<AppServices, RealmServices?>(
          // RealmServices can only be initialized only if the user is logged in.
          create: (context) => null,
          update: (BuildContext context, AppServices appServices, RealmServices? realmServices) {
            return RealmServices(appServices.app);
          }
        ),
      ],
      builder: (context, child) {
        return const MainApp();
      },
    )
  ));
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.darkTheme,
      themeMode: ThemeMode.light,
      initialBinding: GeneralBindings(),
      home: const IntroductionPage(),
    );
  }
}
