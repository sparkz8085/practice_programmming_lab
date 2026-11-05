import java.util.*;
public class GoldBatchNum
{
    int num;
    Scanner sc= new Scanner(System.in);
    GoldBatchNum()
    {
        num=0;
    }
    void input()
    {
        System.out.println("Enter a Number To Check ");
        num=sc.nextInt();
    }
    public static int prime(int x)
    {
        int count =0;
        for(int i=1;i<=x;i++)
        {
            if(x%i==0)
            {
                count++;
            }
        }
        if(count == 2)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    void check()
    {
        int count=0;
        if(num>2)
        {
            for(int i=3; i<num/2; i++)
            {
                int j=num-i;
                if(prime(i)==1 && prime(j)==1)
                {
                    System.out.println(i+" + "+j+" = "+num);
                    count++;
                }
            }
        }
        else
        {
            System.out.println("Not Gold Batch Number ");
        }
        if(count==0)
        {
            System.out.println("Not Gold Batch Number ");
        }
    }
    public static void main(String args[])
    {
        GoldBatchNum obj= new GoldBatchNum();
        obj.input();
        obj.check();
    }
}
