import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph_web/firebase_options.dart';
import 'package:serbizio_ph_web/src/bindings/general_bindings.dart';
import 'package:serbizio_ph_web/src/data/repositories/authentication/authentication_repository.dart';
import 'package:serbizio_ph_web/src/features/user/account_deletion_page.dart';
import 'package:serbizio_ph_web/src/utils/theme/app_theme.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();

  await Firebase.initializeApp(options: DefaultFirebaseOptions.android).then(
    (FirebaseApp value) => Get.put(AuthenticationRepository())
  );

  // To make sure app always portrait up
  await SystemChrome.setPreferredOrientations(
    [DeviceOrientation.portraitUp]
  ).then((value) => runApp(const MainApp()));
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
      home: const AccountDeletion(),
    );
  }
}
