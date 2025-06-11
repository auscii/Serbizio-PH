import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph_web/src/data/repositories/authentication/authentication_repository.dart';
import 'package:serbizio_ph_web/src/data/repositories/user/user_repository.dart';
import 'package:serbizio_ph_web/src/features/core/models/user_model.dart';
import 'package:serbizio_ph_web/src/utils/helpers/network_manager.dart';
import 'package:serbizio_ph_web/src/utils/theme/widget_themes/snackbar_theme.dart';

class UserController extends GetxController {
  static UserController get instance => Get.find();

  Rx<UserModel> user = UserModel.empty().obs;
  final hidePassword = true.obs;
  final verifyEmail = TextEditingController();
  final verifyPassword = TextEditingController();
  final userRepository = Get.put(UserRepository());
  GlobalKey<FormState> reSignInKey = GlobalKey<FormState>();

  @override
  void onInit() {
    super.onInit();
    fetchUserRecord();
  }

  Future<void> fetchUserRecord() async {
    try {
      final user = await userRepository.fetchUserInformation();
      this.user(user);
    } catch (e) {
      user(UserModel.empty());
      // Show some Generic Error to the user
      SnackBarTheme.errorSnackBar(title: 'Error', message: 'Something went wrong. Please try again.');
    }
  }

  void deleteUserAccount() async {
    try {
      final auth = AuthenticationRepository.instance;
      final provider = auth.authUser!.providerData.map((e) => e.providerId).first;

      if (provider.isNotEmpty) {
        if (provider == 'google.com') {
          // await auth.signInWithGoogle();
          await auth.deleteAccount();
          await auth.logout();
        }
      }
    } catch (e) {
      // Show some Generic Error to the user
      SnackBarTheme.errorSnackBar(title: 'Error', message: 'Something went wrong. You can resave your information in your profile.');
    }
  }

  Future<void> reSignInUserWithEmailAndPassword() async {
    try {
      final auth = AuthenticationRepository.instance;

      // Check internet connection
      final isConnected = await NetworkManager.instance.isConnected();
      if (!isConnected) return;

      // Form Validation
      if (!reSignInKey.currentState!.validate()) return;

      await auth.reSignInWithEmailAndPassword(verifyEmail.text.trim(), verifyPassword.text.trim());
      await auth.deleteAccount();
      await auth.logout();

      SnackBarTheme.successSnackBar(title: 'Success', message: 'Your account has been deleted.');
    } catch (e) {
      // Show some Generic Error to the user
      SnackBarTheme.errorSnackBar(title: 'Error', message: 'Something went wrong. Please try again.');
    }
  }
}