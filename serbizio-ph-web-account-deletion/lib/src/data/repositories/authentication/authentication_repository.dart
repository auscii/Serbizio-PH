import 'package:firebase_auth/firebase_auth.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph_web/src/data/repositories/user/user_repository.dart';
import 'package:serbizio_ph_web/src/data/repositories/exceptions/firebase_auth_exception.dart';
import 'package:serbizio_ph_web/src/utils/constants/device_key.dart';
import 'package:serbizio_ph_web/src/utils/data/global.dart';

class AuthenticationRepository extends GetxController {
  static AuthenticationRepository get instance => Get.find();

  // Variables
  final _auth = FirebaseAuth.instance;

  // Get authenticated user data
  User? get authUser => _auth.currentUser;

  @override
  void onReady() {
    screenRedirect();
  }

  void screenRedirect() async {
    // final user = _auth.currentUser;
    // if (user != null) {
    //   Get.offAll(() => const NavigationMenu()); // redirect to HomePage
    // } else {
    //   Get.offAll(() => const IntroductionPage()); // redirect to IntroductionPage
    // }
    Global.deviceID = await DeviceID.get();
    // Get.offAll(() => const NavigationMenu());
  }

  // Email & Password - Register
  Future<UserCredential> createUserWithEmailAndPassword(String email, String password) async {
    try {
      return await _auth.createUserWithEmailAndPassword(email: email, password: password);
    } on FirebaseAuthException catch(e) {
      throw TFirebaseAuthException(e.code).message;
    } catch (e) {
      throw 'Something went wrong. Please try again.';
    }
  }

  // Email & Password - Sign In
  Future<UserCredential> signInWithEmailAndPassword(String email, String password) async {
    try {
      return await _auth.signInWithEmailAndPassword(email: email, password: password);
    } on FirebaseAuthException catch(e) {
      throw TFirebaseAuthException(e.code).message;
    } catch (e) {
      throw 'Something went wrong. Please try again.';
    }
  }

  // Forgot Password
  Future<void> sendEmailResetPassword(String email) async {
    try {
      await _auth.sendPasswordResetEmail(email: email);
    } on FirebaseAuthException catch(e) {
      throw TFirebaseAuthException(e.code).message;
    } catch (e) {
      throw 'Something went wrong. Please try again.';
    }
  }

  // Log Out
  Future<void> logout() async {
    try {
      await _auth.signOut();
    } on FirebaseAuthException catch(e) {
      throw TFirebaseAuthException(e.code).message;
    } catch (e) {
      throw 'Something went wrong. Please try again.';
    }
  }

  Future<void> deleteAccount() async {
    try {
      // await UserRepository.instance.removeUserRecord(_auth.currentUser!.uid);
      final userRepository = Get.put(UserRepository());
      await userRepository.removeUserRecord(_auth.currentUser!.uid);
      await _auth.currentUser?.delete();
    } on FirebaseAuthException catch(e) {
      throw TFirebaseAuthException(e.code).message;
    } catch (e) {
      throw 'Something went wrong. Please try again.';
    }
  }

  // Email & Password - Sign In
  Future<void> reSignInWithEmailAndPassword(String email, String password) async {
    try {
      AuthCredential credential = EmailAuthProvider.credential(email: email, password: password);
      await _auth.currentUser!.reauthenticateWithCredential(credential);
    } on FirebaseAuthException catch(e) {
      throw TFirebaseAuthException(e.code).message;
    } catch (e) {
      throw 'Something went wrong. Please try again.';
    }
  }
}