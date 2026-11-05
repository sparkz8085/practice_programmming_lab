import java.util.*;
public class Palindr
{
    int palin(String word)
    {
        int a,i,f=0;
        String word1="";
        char chr;
        a=word.length();
        for(i=a-1;i>=0;i--)
        {
            chr=word.charAt(i);
            word1=word1+chr;
        }
        if(word.equals(word1))
            f=1;
        return (f);
    }

    public static void main(String args[])
    {
        int k;
        String word="";
        Scanner in = new Scanner(System.in);
        Palindr ob = new Palindr();
        System.out.print("Enter a word in uppercase:");
        word=in.next();
        k=ob.palin(word);
        if(k==1)
            System.out.println("Palindrome word");
        else
            System.out.println("Not a Palindrome word");
    }
}
